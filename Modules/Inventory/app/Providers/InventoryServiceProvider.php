<?php

namespace Modules\Inventory\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Inventory\Models\InventoryItem;
use Modules\Inventory\Observers\InventoryItemObserver;

class InventoryServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        InventoryItem::observe(InventoryItemObserver::class);
    }
}
