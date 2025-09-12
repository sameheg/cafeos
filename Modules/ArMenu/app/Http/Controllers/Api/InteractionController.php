<?php

namespace Modules\ArMenu\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ArMenu\Models\ArAsset;
use Modules\ArMenu\Models\ArInteraction;

class InteractionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'item_id' => ['required', 'string']
        ]);
        $asset = ArAsset::where('item_id', $validated['item_id'])->firstOrFail();
        $asset->markViewed('ar');
        ArInteraction::create([
            'tenant_id' => $asset->tenant_id,
            'asset_id' => $asset->id,
            'timestamp' => now(),
        ]);
        return response()->json(['logged' => true]);
    }
}
