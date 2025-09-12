<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosRefund;

class RefundController
{
    public function refund(Request $r, PosOrder $order): JsonResponse {
        $data = $r->validate(['amount'=>'required|numeric|min:0','reason'=>'nullable|string','items'=>'array']);
        $rf = PosRefund::create([
            'tenant_id'=>$order->tenant_id,
            'order_id'=>$order->id,
            'amount'=>$data['amount'],
            'reason'=>$data['reason'] ?? null,
            'items'=>$data['items'] ?? [],
        ]);
        // TODO: reverse inventory if needed
        return response()->json(['refund'=>$rf]);
    }
}
