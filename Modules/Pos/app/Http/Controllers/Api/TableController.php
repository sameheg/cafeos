<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosTable;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Services\InventoryService;
use Modules\Pos\Services\TotalsCalculator;

class TableController
{
    public function show(PosTable $table): JsonResponse {
        return response()->json(['table' => $table->load('order')]);
    }

    public function startOrder(PosTable $table): JsonResponse {
        if ($table->status === 'occupied' && $table->current_order_id) {
            return response()->json(['order_id' => $table->current_order_id], 200);
        }
        $order = PosOrder::create([
            'tenant_id' => $table->tenant_id,
            'status' => 'open',
        ]);
        $table->update(['status' => 'occupied','current_order_id'=>$order->id]);
        return response()->json(['order_id'=>$order->id], 201);
    }

    public function addItem(Request $req, PosOrder $order): JsonResponse {
        $data = $req->validate([
            'name'=>'required','price'=>'required|numeric','qty'=>'required|integer|min:1'
        ]);
        $item = $order->items()->create($data);
        return response()->json(['item'=>$item],201);
    }

    public function closeOrder(PosOrder $order): JsonResponse {
        $order->update(['status'=>'closed']);
        if ($order->table) {
            $order->table->update(['status'=>'available','current_order_id'=>null]);
        }
        return response()->json(['closed'=>true]);
    }
}
