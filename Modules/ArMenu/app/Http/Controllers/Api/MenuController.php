<?php

namespace Modules\ArMenu\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\ArMenu\Models\ArAsset;

class MenuController extends Controller
{
    public function show(string $id): JsonResponse
    {
        $asset = ArAsset::findOrFail($id);
        return response()->json(['asset_url' => $asset->url]);
    }
}
