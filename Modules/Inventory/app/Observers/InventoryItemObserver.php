<?php

namespace Modules\Inventory\Observers;

use Modules\Inventory\Models\InventoryItem;
use Modules\Inventory\Events\StockUpdated;

class InventoryItemObserver
{
    public function updated(InventoryItem $item): void
    {
        StockUpdated::dispatch($item);
    }
}
