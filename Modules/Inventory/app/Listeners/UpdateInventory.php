<?php

namespace Modules\Inventory\Listeners;

use App\Events\OrderCreated;
use Illuminate\Support\Facades\Log;
use Modules\Core\Contracts\InventoryServiceInterface;
use Nwidart\Modules\Facades\Module as Modules;

class UpdateInventory
{
    public function handle(OrderCreated $event): void
    {
        if (!Modules::isEnabled('Inventory')) {
            Log::warning('Fallback: No stock update');
            return;
        }

        $service = app(InventoryServiceInterface::class);
        $service->deductStock($event->order->menuItems);
    }
}
