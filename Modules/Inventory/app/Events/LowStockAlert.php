<?php

namespace Modules\Inventory\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Inventory\Models\InventoryItem;

class LowStockAlert
{
    use Dispatchable;

    public function __construct(public InventoryItem $item) {}
}
