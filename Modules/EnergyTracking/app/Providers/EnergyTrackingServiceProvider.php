<?php

namespace Modules\EnergyTracking\Providers;

use Illuminate\Support\ServiceProvider;

class EnergyTrackingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register services related to tracking energy consumption per equipment
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Bootstrapping logic for energy tracking features
    }
}
