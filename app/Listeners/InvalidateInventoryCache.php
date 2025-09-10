<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Cache;
use Modules\Inventory\Events\InventoryCacheInvalidated;

class InvalidateInventoryCache
{
    public function handle(InventoryCacheInvalidated $event): void
    {
        Cache::tags('inventory')->flush();
    }
}
