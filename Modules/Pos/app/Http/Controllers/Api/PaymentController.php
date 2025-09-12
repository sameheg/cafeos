<?php
namespace Modules\Pos\App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pos\App\Models\Order;
use Modules\Pos\App\Contracts\BillingGateway;
use Modules\Pos\App\Contracts\InventoryGateway;
use Modules\Pos\App\Services\PosAudit;

class PaymentController extends Controller
{
    public function __construct(
        private BillingGateway $billing,
        private InventoryGateway $inventory,
        private PosAudit $audit
    ) {}

    public function pay(Request $request, Order $order)
    {
        $this->authorize('update', $order);

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

            // finalize inventory
            $this->inventory->consumeItems($order->items->map(fn($i) => [
                'sku' => $i->sku,
                'qty' => $i->qty,
            ])->toArray(), ['order_id' => $order->id]);

            $order->status = 'paid';
            $order->paid_at = now();
            $order->invoice_id = $invoice['invoice_id'] ?? null;
            $order->paid_total = (float)$amount;
            $order->save();

            if (function_exists('loyalty_award')) {
                loyalty_award($order->customer_id ?? null, $order->total);
            }

            $this->audit->log('order.paid', ['order_id'=>$order->id,'amount'=>$amount]);

            return response()->json([
                'message' => 'Payment successful',
                'order_id' => $order->id,
                'invoice' => $invoice,
            ]);
        });
    }
}
