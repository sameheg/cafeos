<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosItem;

class KitchenController
{
    public function setStatus(PosItem $item, string $status): JsonResponse {
        abort_unless(in_array($status, ['pending','preparing','ready','served','void']), 403);
        $item->update(['kitchen_status'=>$status]);
        return response()->json(['item'=>$item]);
    }
}
