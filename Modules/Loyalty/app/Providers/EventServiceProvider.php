<?php

namespace Modules\Loyalty\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Pos\Events\OrderPaid;
use Modules\Loyalty\Listeners\EarnPointsFromOrder;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPaid::class => [EarnPointsFromOrder::class],
    ];

    protected static $shouldDiscoverEvents = true;
}
