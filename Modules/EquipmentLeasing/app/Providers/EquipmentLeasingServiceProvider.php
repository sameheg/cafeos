<?php

namespace Modules\EquipmentLeasing\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\EquipmentLeasing\Models\EquipmentLease;
use Modules\EquipmentLeasing\Observers\EquipmentLeaseObserver;
use Modules\EquipmentLeasing\Listeners\PaymentReceivedListener;

class EquipmentLeasingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('EquipmentLeasing', 'database/migrations'));
        EquipmentLease::observe(EquipmentLeaseObserver::class);
        Event::listen('billing.payment.received@v1', [PaymentReceivedListener::class, 'handle']);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

