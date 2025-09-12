<?php

namespace Modules\Pos\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Pos\Models\PosItem;
use Modules\Pos\Models\PosItemModifier;

class ModifierController
{
    public function add(Request $r, PosItem $item): JsonResponse {
        $data = $r->validate(['name'=>'required','price'=>'numeric','meta'=>'array']);
        $m = PosItemModifier::create([
            'tenant_id'=>$item->tenant_id,
            'item_id'=>$item->id,
            'name'=>$data['name'],
            'price'=>$data['price'] ?? 0,
            'meta'=>$data['meta'] ?? [],
        ]);
        return response()->json(['modifier'=>$m],201);
    }
}
