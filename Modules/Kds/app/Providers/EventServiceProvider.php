<?php

namespace Modules\Kds\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Kds\Listeners\CreateKitchenTicket;
use Modules\Pos\Events\OrderCreated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            CreateKitchenTicket::class,
        ],
    ];
}
