<?php

namespace Modules\ArMenu\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\ArMenu\Events\ArMenuViewed;
use Modules\ArMenu\Listeners\CartUpdatedListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'pos.cart.updated@v1' => [CartUpdatedListener::class],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
