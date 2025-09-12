<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosRefund;
use Modules\Pos\Services\InventoryService;
use Modules\Pos\Models\PosAudit;

class RefundController
{
    public function refund(Request $r, PosOrder $order): JsonResponse {
        $data = $r->validate(['amount'=>'required|numeric|min:0','reason'=>'nullable|string','items'=>'array']);
        abort_unless(auth()->user()?->can('pos.order.refund'), 403);
        $rf = PosRefund::create([
            'tenant_id'=>$order->tenant_id,
            'order_id'=>$order->id,
            'amount'=>$data['amount'],
            'reason'=>$data['reason'] ?? null,
            'items'=>$data['items'] ?? [],
        ]);
        // reverse inventory
        foreach(($data['items'] ?? []) as $it){
            if(isset($it['id'])){
                $item = $order->items()->find($it['id']);
                if($item) InventoryService::reverseForItem($item);
            }
        }
        // audit
        PosAudit::create([
            'tenant_id'=>$order->tenant_id,
            'user_id'=>$r->user()->id ?? null,
            'action'=>'refund.created',
            'entity_type'=>'order',
            'entity_id'=>$order->id,
            'data'=>$rf->toArray()
        ]);
        return response()->json(['refund'=>$rf]);
    }
}
