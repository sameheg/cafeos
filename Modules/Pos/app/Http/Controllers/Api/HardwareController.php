<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosPrinter;

class HardwareController
{
    public function printReceipt(PosOrder $order, PosPrinter $printer): JsonResponse {
        // TODO: invoke actual driver / queue job
        return response()->json(['ok'=>true,'printed_on'=>$printer->name,'order_id'=>$order->id]);
    }

    public function openDrawer(PosPrinter $printer): JsonResponse {
        // TODO: send ESC/POS command
        return response()->json(['ok'=>true,'drawer'=>'opened','printer'=>$printer->name]);
    }
}
