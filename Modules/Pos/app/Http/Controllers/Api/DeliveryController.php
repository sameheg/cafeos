<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;

class DeliveryController
{
    public function assignDriver(Request $r, PosOrder $order): JsonResponse {
        $data = $r->validate(['driver_id'=>'required','delivery_address'=>'nullable']);
        $order->update([
            'driver_id'=>$data['driver_id'],
            'delivery_address'=>$data['delivery_address'] ?? $order->delivery_address,
            'delivery_status'=>'assigned',
            'order_type'=>'delivery'
        ]);
        return response()->json(['order'=>$order]);
    }

    public function setStatus(PosOrder $order, string $status): JsonResponse {
        abort_unless(in_array($status, ['assigned','picked_up','delivered','canceled']), 403);
        $order->update(['delivery_status'=>$status]);
        return response()->json(['order'=>$order]);
    }
}
