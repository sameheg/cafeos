<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosSyncToken;

class OfflineSyncController
{
    public function token(Request $r): JsonResponse {
        $data = $r->validate(['tenant_id'=>'required','device_id'=>'required']);
        $token = PosSyncToken::firstOrCreate(['tenant_id'=>$data['tenant_id'],'device_id'=>$data['device_id']]);
        return response()->json(['token'=>$token->last_token]);
    }
    public function push(Request $r): JsonResponse {
        // accept offline mutations batch
        $payload = $r->validate(['mutations'=>'required|array']);
        // TODO: apply mutations (orders/items/payments) with idempotency
        return response()->json(['ok'=>true]);
    }
}
