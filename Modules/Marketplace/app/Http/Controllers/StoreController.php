<?php

namespace Modules\Marketplace\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Marketplace\Models\MarketplaceStore;

class StoreController extends Controller
{
    public function show(string $supplierId): JsonResponse
    {
        $store = MarketplaceStore::where('supplier_id', $supplierId)->firstOrFail();
        $listings = $store->listings()->get(['id', 'item_id', 'price', 'stock']);

        return response()->json(['listings' => $listings]);
    }
}
