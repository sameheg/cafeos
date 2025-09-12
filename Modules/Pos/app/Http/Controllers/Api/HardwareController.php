<?php

namespace Modules\Pos\Http\Controllers\Api;

use Modules\Pos\Services\HardwarePrinter;

use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosPrinter;

class HardwareController
{
    public function printReceipt(PosOrder $order, PosPrinter $printer): JsonResponse {
        // Example ESC/POS call (stub)
        \Log::info('Printing receipt',['order_id'=>$order->id,'printer'=>$printer->endpoint]);
        $ok = $printer->endpoint ? HardwarePrinter::printRaw($printer->endpoint, "ORDER #{$order->id}\nTOTAL: {$order->total}\n\n") : false;
        return response()->json(['ok'=>$ok,'printed_on'=>$printer->name,'order_id'=>$order->id]);
    }

    public function openDrawer(PosPrinter $printer): JsonResponse {
        \Log::info('Drawer opened',['printer'=>$printer->endpoint]);
        $ok = $printer->endpoint ? HardwarePrinter::openDrawerRaw($printer->endpoint) : false;
        return response()->json(['ok'=>$ok,'drawer'=>$ok?'opened':'failed','printer'=>$printer->name]);
    }
}
