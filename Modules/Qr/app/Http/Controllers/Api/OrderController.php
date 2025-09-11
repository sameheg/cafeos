<?php

namespace Modules\Qr\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Qr\Models\QrCode;
use Modules\Qr\Models\QrOrder;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'table_id' => 'required|string',
        ]);

        $qr = QrCode::where('table_id', $data['table_id'])->firstOrFail();
        $total = collect($data['items'])->sum(fn ($item) => $item['price'] ?? 0);

        if ($total <= 0) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $order = QrOrder::create([
            'tenant_id' => $qr->tenant_id,
            'qr_id' => $qr->id,
            'status' => QrOrder::STATUS_PLACED,
            'total' => $total,
        ]);

        return response()->json(['order_id' => $order->id]);
    }
}
