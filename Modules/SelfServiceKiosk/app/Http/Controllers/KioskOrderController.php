<?php

namespace Modules\SelfServiceKiosk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Pos\Events\OrderCreated;
use Modules\Pos\Models\Order;

class KioskOrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'total' => 'required|numeric',
            'order_type' => 'required|in:drive_thru,takeaway',
        ]);

        $queueNumber = (int) Order::max('queue_number') + 1;

        $order = Order::create([
            'tenant_id' => tenant('id'),
            'total' => $data['total'],
            'status' => 'pending',
            'order_type' => $data['order_type'],
            'queue_number' => $queueNumber,
        ]);

        event(new OrderCreated($order, tenant()));

        return response()->json([
            'order_id' => $order->id,
            'queue_number' => $queueNumber,
        ], 201);
    }
}
