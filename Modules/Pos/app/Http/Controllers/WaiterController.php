<?php

namespace Modules\Pos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pos\Events\TableOpened;
use Modules\Pos\Models\Order;
use Modules\Pos\Services\BillingService;

class WaiterController extends Controller
{
    public function index()
    {
        return view('pos::waiter.index');
    }

    public function move(Request $request, Order $order)
    {
        $data = $request->validate([
            'table_id' => ['required', 'integer'],
        ]);

        $order->table_id = $data['table_id'];
        $order->save();

        event(new TableOpened($order));

        return response()->json(['message' => __('pos::moved')]);
    }

    public function split(Request $request, Order $order, BillingService $billing)
    {
        $data = $request->validate([
            'parts' => ['required', 'integer', 'min:2'],
        ]);

        $parts = $billing->splitBill($order, (int) $data['parts']);
        $order->split = $parts;
        $order->save();

        return response()->json([
            'message' => __('pos::split'),
            'parts' => $parts,
        ]);
    }
}
