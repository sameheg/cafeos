<?php

namespace Modules\ArMenu\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\ArMenu\Models\ArAsset;

class CartUpdatedListener
{
    /**
     * Handle pos.cart.updated@v1 events.
     */
    public function handle(array $event): void
    {
        $asset = ArAsset::where('item_id', $event['data']['item_id'] ?? null)->first();
        if ($asset) {
            $asset->markAdded();
        }
        Log::info('cart updated processed', ['event' => $event]);
    }
}
