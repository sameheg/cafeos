<?php

namespace Modules\EquipmentLeasing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Core\Contracts\InventoryServiceInterface;
use Modules\EquipmentLeasing\Models\LeaseContract;
use Modules\Marketplace\Models\Product;

class LeaseController extends Controller
{
    public function index()
    {
        return LeaseContract::all();
    }

    public function store(Request $request, InventoryServiceInterface $inventory)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:marketplace_products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'schedule' => ['nullable', 'array'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $product = Product::findOrFail($data['product_id']);
        $total = $product->price * $data['quantity'];

        $lease = LeaseContract::create([
            'product_id' => $product->id,
            'quantity' => $data['quantity'],
            'schedule' => $data['schedule'] ?? [],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'total' => $total,
        ]);

        $inventory->deductStock([
            ['id' => $product->inventory_item_id, 'quantity' => $data['quantity']],
        ]);

        return response()->json($lease, 201);
    }
}
