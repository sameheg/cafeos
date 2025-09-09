<?php

namespace Modules\Kds\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Pos\Events\OrderCreated;
use Modules\Kds\Listeners\CreateKitchenTicket;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            CreateKitchenTicket::class,
        ],
    ];
}
