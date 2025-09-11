<?php

namespace Modules\Pos\Events;

use Illuminate\Foundation\Events\Dispatchable;

class InventoryStockUpdated
{
    use Dispatchable;

    public function __construct(public string $eventId)
    {
    }
}
