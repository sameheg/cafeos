<?php

namespace App\Http\Controllers\Restaurant;

use App\Restaurant\TableOrder;
use App\Services\WaiterNotificationService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use DNS2D;

class QROrderController extends Controller
{
    public function menu($table)
    {
        $items = [
            ['id' => 1, 'name' => 'Coffee', 'price' => 2.5],
            ['id' => 2, 'name' => 'Tea', 'price' => 2.0],
        ];

        return response()->json([
            'table_id' => (int) $table,
            'items' => $items,
        ]);
    }

    public function qr($table)
    {
        $url = url('/restaurant/tables/' . $table . '/menu');
        $png = DNS2D::getBarcodePNG($url, 'QRCODE');

        return response(base64_decode($png))->header('Content-Type', 'image/png');
    }

    public function order(Request $request, $table)
    {
        $order = TableOrder::create([
            'table_id' => $table,
            'status' => 'pending',
            'placed_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'table_id' => (int) $table,
            'order_id' => $order->id,
            'status' => $order->status,
            'items' => $request->input('items', []),
        ]);
    }

    public function ready(TableOrder $order, WaiterNotificationService $notifications)
    {
        $order->status = 'ready';
        $order->save();

        $notifications->notifyTicketReady($order);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'status' => $order->status,
        ]);
    }

    public function orders($table)
    {
        $orders = TableOrder::where('table_id', $table)->get(['id', 'status', 'placed_at', 'transaction_id']);

        return response()->json([
            'table_id' => (int) $table,
            'orders' => $orders,
        ]);
    }

    public function view($table)
    {
        return view('restaurant.table.orders', ['tableId' => (int) $table]);
    }
}
