<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Inventory\Models\InventoryItem;

class InventoryItemController extends Controller
{
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'quantity' => 'required|numeric|min:0'
        ]);

        $item = InventoryItem::findOrFail($id);
        $item->quantity = $data['quantity'];
        $item->save();

        return response()->json(['updated_item' => $item]);
    }

    public function lowStock()
    {
        $items = InventoryItem::whereColumn('quantity', '<=', 'reorder_level')->get();
        if ($items->isEmpty()) {
            return response()->json(['items' => []]);
        }
        return response()->json(['items' => $items]);
    }
}
