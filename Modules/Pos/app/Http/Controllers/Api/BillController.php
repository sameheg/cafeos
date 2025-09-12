<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosBill;
use Modules\Pos\Models\PosBillItem;

class BillController
{
    public function index(PosOrder $order): JsonResponse {
        return response()->json(['data'=> $order->bills()->with('items')->get() ]);
    }
    public function create(Request $r, PosOrder $order): JsonResponse {
        $data = $r->validate(['label'=>'nullable']);
        $b = PosBill::create(['tenant_id'=>$order->tenant_id,'order_id'=>$order->id,'label'=>$data['label'] ?? null]);
        return response()->json(['data'=>$b],201);
    }
    public function addItem(Request $r, PosOrder $order, PosBill $bill): JsonResponse {
        abort_unless($bill->order_id === $order->id, 404);
        $data = $r->validate(['order_item_id'=>'required','qty'=>'integer|min:1','price'=>'numeric']);
        $bi = PosBillItem::create([
            'tenant_id'=>$order->tenant_id,
            'bill_id'=>$bill->id,
            'order_item_id'=>$data['order_item_id'],
            'qty'=>$data['qty'] ?? 1,
            'price'=>$data['price'] ?? 0,
            'line_total'=> ($data['price'] ?? 0) * ($data['qty'] ?? 1),
        ]);
        return response()->json(['data'=>$bi],201);
    }
}
