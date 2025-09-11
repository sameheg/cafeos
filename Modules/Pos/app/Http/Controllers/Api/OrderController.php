<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'table_id' => 'nullable|string',
        ]);

        $tenantId = $request->user()?->tenant_id ?? 'tenant-demo';

        return DB::transaction(function () use ($data, $tenantId) {
            $order = PosOrder::create([
                'tenant_id' => $tenantId,
                'table_id' => $data['table_id'] ?? null,
                'total' => collect($data['items'])->reduce(fn($c, $i) => $c + ($i['price'] * $i['qty']), 0),
            ]);

            foreach ($data['items'] as $item) {
                PosItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                ]);
            }

            return response()->json([
                'order_id' => $order->id,
                'total' => $order->total,
            ]);
        });
    }

    public function show(string $id)
    {
        $order = PosOrder::with('items')->findOrFail($id);
        return response()->json($order);
    }
}
