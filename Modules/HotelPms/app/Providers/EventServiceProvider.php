<?php

namespace Modules\HotelPms\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Pos\Events\OrderPaid;
use Modules\HotelPms\Listeners\HandleOrderPaid;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPaid::class => [HandleOrderPaid::class],
    ];

    protected static $shouldDiscoverEvents = true;
}
