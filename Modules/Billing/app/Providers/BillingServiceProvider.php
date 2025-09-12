<?php

namespace Modules\Billing\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Billing\Listeners\MembershipRenewedListener;

class BillingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('Billing', 'database/migrations'));
        $this->app['events']->subscribe(MembershipRenewedListener::class);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
