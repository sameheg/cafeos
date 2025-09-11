<?php

namespace Modules\Qr\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // domain events consumed can be registered here
    ];

    protected static $shouldDiscoverEvents = true;
}
