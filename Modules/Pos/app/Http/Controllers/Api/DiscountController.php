<?php

namespace Modules\Pos\Http\Controllers\Api;

use Modules\Pos\Models\PosAudit;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosDiscount;

class DiscountController
{
    public function apply(Request $r, PosOrder $order): JsonResponse {
        $data = $r->validate(['scope'=>'in:order,item','amount'=>'numeric','percent'=>'numeric','code'=>'nullable','meta'=>'array']);
        abort_unless(auth()->user()?->can('pos.order.discount'), 403);
        $d = PosDiscount::create([
            'tenant_id'=>$order->tenant_id,
            'order_id'=>$order->id,
            'scope'=>$data['scope'] ?? 'order',
            'amount'=>$data['amount'] ?? 0,
            'percent'=>$data['percent'] ?? 0,
            'code'=>$data['code'] ?? null,
            'meta'=>$data['meta'] ?? [],
        ]);
        PosAudit::create(['tenant_id'=>$order->tenant_id,'user_id'=>auth()->id(),'action'=>'order.discount','entity_type'=>'order','entity_id'=>$order->id,'data'=>$d->toArray()]);
        return response()->json(['discount'=>$d]);
    }
}
