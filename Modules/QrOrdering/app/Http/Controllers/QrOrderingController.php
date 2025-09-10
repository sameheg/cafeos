<?php

namespace Modules\QrOrdering\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Kds\Models\KitchenTicket;
use Modules\Pos\Events\OrderCreated;
use Modules\Pos\Models\MenuItem;
use Modules\Pos\Models\Order;

class QrOrderingController extends Controller
{
    public function menu()
    {
        $items = MenuItem::all();

        return view('qrordering::menu', compact('items'));
    }

    public function placeOrder(Request $request)
    {
        $itemIds = $request->input('items', []);
        $items = MenuItem::whereIn('id', $itemIds)->get();
        $total = $items->sum('price');

        $order = Order::create([
            'total' => $total,
            'status' => 'pending',
            'is_debt' => false,
        ]);

        $order->menuItems()->attach($itemIds);

        event(new OrderCreated($order));

        return response()->json(['order_id' => $order->id]);
    }

    public function approve(Order $order)
    {
        $ticket = KitchenTicket::where('order_id', $order->id)->firstOrFail();
        $ticket->update(['approved' => true]);

        return response()->json(['status' => 'approved']);
    }
}
