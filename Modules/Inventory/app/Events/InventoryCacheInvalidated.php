<?php

namespace Modules\Inventory\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Inventory\Models\InventoryItem;

class InventoryCacheInvalidated
{
    use Dispatchable, SerializesModels;

    public function __construct(public InventoryItem $item)
    {
    }
}
