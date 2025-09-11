<?php

namespace Modules\Pos\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Pos\Events\InventoryStockUpdated;
use Modules\Pos\Listeners\HandleInventoryStockUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        InventoryStockUpdated::class => [HandleInventoryStockUpdated::class],
    ];

    protected static $shouldDiscoverEvents = true;
}
