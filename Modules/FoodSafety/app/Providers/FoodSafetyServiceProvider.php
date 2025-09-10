<?php

namespace Modules\FoodSafety\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\FoodSafety\Console\Commands\CheckExpiryAlerts;
use Modules\FoodSafety\Services\FoodSafetyService;

class FoodSafetyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FoodSafetyService::class, fn () => new FoodSafetyService);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        if ($this->app->runningInConsole()) {
            $this->commands([
                CheckExpiryAlerts::class,
            ]);
        }
    }
}
