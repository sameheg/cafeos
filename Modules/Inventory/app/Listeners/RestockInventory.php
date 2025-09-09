<?php

namespace Modules\Inventory\Listeners;

use Modules\Core\Contracts\InventoryServiceInterface;

class RestockInventory
{
    public function handle(object $event): void
    {
        $service = app(InventoryServiceInterface::class);
        $service->restock($event->items);
    }
}
