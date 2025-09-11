<?php

namespace Modules\Kiosk\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'inventory.stock.checked@v1' => [
            \Modules\Kiosk\Listeners\InventoryStockCheckedListener::class,
        ],
    ];

    protected static $shouldDiscoverEvents = true;
}
