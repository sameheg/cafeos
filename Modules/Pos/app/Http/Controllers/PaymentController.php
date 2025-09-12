<?php
namespace Modules\Pos\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pos\App\Models\Order;
use Modules\Pos\App\Contracts\BillingGateway;
use Modules\Pos\App\Contracts\InventoryGateway;

/**
 * @group POS Payments
 *
 * APIs for processing order payments
 */
class PaymentController extends Controller
{
    public function __construct(
        private BillingGateway $billing,
        private InventoryGateway $inventory
    ) {}

    /**
     * Pay for an order
     *
     * Process payment, recalc totals, create invoice, consume inventory, and award loyalty points.
     *
     * @urlParam order int required The ID of the order
     * @bodyParam amount float required The payment amount. Example: 100.0
     * @bodyParam method string optional The payment method. Default: cash. Example: card
     *
     * @response 200 {"message": "Payment successful", "order_id": 1, "invoice": {"invoice_id": "INV-123", "number": "2025-0001", "total": 100}}
     * @response 409 {"message": "Order already paid"}
     * @response 422 {"message": "Insufficient payment"}
     */
    public function pay(Request $request, Order $order)
    {
        if ($order->status === 'paid') {
            return response()->json(['message' => 'Order already paid'], 409);
        }

        return DB::transaction(function () use ($request, $order) {
            $order->recalcTotals();
            $amount = (float)$request->input('amount', $order->total);
            if ($amount < (float)$order->total) {
                return response()->json(['message' => 'Insufficient payment'], 422);
            }

            $invoice = $this->billing->createInvoice($order->fresh('items'), $order->items->toArray(), [
                'method' => $request->input('method', 'cash'),
            ]);

            $this->inventory->consumeItems($order->items->map(fn($i) => [
                'sku' => $i->sku,
                'qty' => $i->qty,
            ])->toArray(), ['order_id' => $order->id]);

            $order->status = 'paid';
            $order->paid_at = now();
            $order->invoice_id = $invoice['invoice_id'] ?? null;
            $order->save();

            if (function_exists('loyalty_award')) {
                loyalty_award($order->customer_id ?? null, $order->total);
            }

            return response()->json([
                'message' => 'Payment successful',
                'order_id' => $order->id,
                'invoice' => $invoice,
            ]);
        });
    }
}
