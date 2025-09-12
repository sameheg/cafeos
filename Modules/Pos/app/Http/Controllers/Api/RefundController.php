<?php
namespace Modules\Pos\App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pos\App\Models\Order;
use Modules\Pos\App\Models\Refund;
use Modules\Pos\App\Models\RefundItem;
use Modules\Pos\App\Services\TotalsCalculator;
use Modules\Pos\App\Services\PosAudit;

class RefundController extends Controller
{
    public function __construct(private PosAudit $audit) {}

    public function refund(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $data = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.order_item_id' => 'required_with:items|integer',
            'items.*.qty' => 'required_with:items|numeric|min:0.01',
            'items.*.amount' => 'required_with:items|numeric|min:0',
        ]);

        return DB::transaction(function () use ($order, $data) {
            $order->recalcTotals();

            $alreadyRefunded = (float)$order->refunded_total;
            $paid = (float)$order->paid_total;
            $amount = (float)$data['amount'];

            if ($amount + $alreadyRefunded > $paid) {
                return response()->json(['message'=>'Refund exceeds paid total'], 422);
            }

            $refund = Refund::create([
                'order_id' => $order->id,
                'amount' => $amount,
                'reason' => $data['reason'] ?? null,
            ]);

            if (!empty($data['items'])) {
                foreach ($data['items'] as $ri) {
                    RefundItem::create([
                        'refund_id' => $refund->id,
                        'order_item_id' => $ri['order_item_id'],
                        'qty' => $ri['qty'],
                        'amount' => $ri['amount'],
                    ]);
                }
            }

            $order->refunded_total = $alreadyRefunded + $amount;
            $order->save();

            app(TotalsCalculator::class)->recalc($order);

            $this->audit->log('order.refund', ['order_id'=>$order->id,'amount'=>$amount]);

            return response()->json(['message'=>'Refund created','refund_id'=>$refund->id], 201);
        });
    }
}
