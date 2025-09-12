<?php

namespace Modules\Rentals\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Rentals\Models\Contract;
use Modules\Rentals\Observers\ContractObserver;

class RentalsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('Rentals', 'database/migrations'));
        Contract::observe(ContractObserver::class);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
