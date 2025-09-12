<?php
namespace Modules\Pos\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pos\App\Models\Order;
use Modules\Pos\App\Models\OrderItem;
use Modules\Inventory\App\Services\InventoryService;
use Modules\Pos\App\Services\TotalsCalculator;

class OrderController extends Controller
{
    public function addItem(Request $request, Order $order)
    {
        $data = $request->validate([
            'sku' => 'required|string',
            'name' => 'required|string',
            'qty' => 'required|numeric|min:0.01',
            'price' => 'required|numeric|min:0',
        ]);

        $item = $order->items()->create($data);

        if (class_exists(InventoryService::class)) {
            app(InventoryService::class)->consume($item->sku, $item->qty);
        }

        app(TotalsCalculator::class)->recalc($order->fresh('items'));

        return response()->json($item->fresh(), 201);
    }

    public function void(Order $order)
    {
        $order->status = 'void';
        $order->save();
        return response()->json($order);
    }
}
