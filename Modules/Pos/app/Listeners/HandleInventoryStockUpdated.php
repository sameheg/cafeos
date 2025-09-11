<?php

namespace Modules\Pos\Listeners;

use Illuminate\Support\Facades\Cache;
use Modules\Pos\Events\InventoryStockUpdated;

class HandleInventoryStockUpdated
{
    public function handle(InventoryStockUpdated $event): void
    {
        Cache::put("inventory-event-{$event->eventId}", true, now()->addDay());
    }
}
