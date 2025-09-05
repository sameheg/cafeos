<?php

namespace App\Http\Controllers\Restaurant;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        return response()->json([
            'success' => true,
            'table_id' => (int) $table,
            'items' => $request->input('items', []),
        ]);
    }
}
