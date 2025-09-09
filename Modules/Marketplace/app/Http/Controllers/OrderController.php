<?php

namespace Modules\Marketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Marketplace\Models\Order;
use Modules\Marketplace\Models\Product;
use Modules\Core\Contracts\InventoryServiceInterface;

class OrderController extends Controller
{
    public function store(Request $request, Product $product, InventoryServiceInterface $inventory)
    {
        $data = $request->validate([
            'tenant_id' => ['required','integer'],
            'quantity' => ['required','integer','min:1'],
        ]);

        $quantity = $data['quantity'];

        $order = Order::create([
            'tenant_id' => $data['tenant_id'],
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total' => $product->price * $quantity,
        ]);

        $inventory->deductStock([
            ['id' => $product->inventory_item_id, 'quantity' => $quantity],
        ]);

        return response()->json($order, 201);
    }
}
