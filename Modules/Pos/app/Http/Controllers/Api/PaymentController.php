<?php

namespace Modules\Pos\Http\Controllers\Api;

use Modules\Pos\Models\PosAudit;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosPayment;

class PaymentController
{
    public function pay(Request $r, PosOrder $order): JsonResponse {
        $data = $r->validate(['method'=>'required','amount'=>'required|numeric','meta'=>'array']);
        abort_unless(auth()->user()?->can('pos.order.pay'), 403);
        $p = PosPayment::create([
            'tenant_id'=>$order->tenant_id,
            'order_id'=>$order->id,
            'method'=>$data['method'],
            'amount'=>$data['amount'],
            'status'=>'captured',
            'meta'=>$data['meta'] ?? [],
        ]);
        $order->update(['status'=>'paid']);
        PosAudit::create(['tenant_id'=>$order->tenant_id,'user_id'=>auth()->id(),'action'=>'order.pay','entity_type'=>'order','entity_id'=>$order->id,'data'=>$p->toArray()]);
        return response()->json(['payment'=>$p,'order_status'=>$order->status]);
    }
}
