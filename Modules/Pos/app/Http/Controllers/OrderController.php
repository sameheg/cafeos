<?php

namespace Modules\Pos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Pos\Events\OrderCreated;
use Modules\Pos\Events\TableOpened;
use Modules\Pos\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::create($request->only(['total', 'status']));

        event(new OrderCreated($order, tenant()));
        event(new TableOpened($order, tenant()));

        return response()->json($order, 201);
    }
}
