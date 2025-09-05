<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Transaction;
use Illuminate\Http\Request;

/**
 * @group Orders
 * @authenticated
 *
 * APIs for managing orders
 */
class OrderApiController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Transaction::paginate());
    }

    public function store(Request $request)
    {
        $order = Transaction::create($request->all());

        return new OrderResource($order);
    }

    public function show(Transaction $order)
    {
        return new OrderResource($order);
    }

    public function update(Request $request, Transaction $order)
    {
        $order->update($request->all());

        return new OrderResource($order);
    }

    public function destroy(Transaction $order)
    {
        $order->delete();

        return response()->noContent();
    }
}
