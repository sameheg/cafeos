<?php

namespace Modules\Pos\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Pos\Events\OrderCreated;
use Illuminate\Http\Request;
use Modules\Pos\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::create($request->only(['tenant_id', 'total', 'status']));

        event(new OrderCreated($order, tenant()));

        return response()->json($order, 201);
    }
}
