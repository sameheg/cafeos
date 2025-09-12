<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosDiscount;

class DiscountController
{
    public function apply(Request $r, PosOrder $order): JsonResponse {
        $data = $r->validate(['scope'=>'in:order,item','amount'=>'numeric','percent'=>'numeric','code'=>'nullable','meta'=>'array']);
        $d = PosDiscount::create([
            'tenant_id'=>$order->tenant_id,
            'order_id'=>$order->id,
            'scope'=>$data['scope'] ?? 'order',
            'amount'=>$data['amount'] ?? 0,
            'percent'=>$data['percent'] ?? 0,
            'code'=>$data['code'] ?? null,
            'meta'=>$data['meta'] ?? [],
        ]);
        return response()->json(['discount'=>$d]);
    }
}
