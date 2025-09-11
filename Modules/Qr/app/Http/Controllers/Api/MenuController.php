<?php

namespace Modules\Qr\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Qr\Models\QrCode;

class MenuController extends Controller
{
    public function show(string $tableId): JsonResponse
    {
        $qr = QrCode::where('table_id', $tableId)->first();
        if (! $qr) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $menu = [
            ['id' => 1, 'name' => 'Coffee', 'price' => 3.50],
            ['id' => 2, 'name' => 'Tea', 'price' => 2.00],
        ];

        return response()->json(['menu' => $menu]);
    }
}
