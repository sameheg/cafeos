<?php

namespace Modules\HotelPms\Providers;

use Illuminate\Support\ServiceProvider;

class HotelPmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register bindings for hotel PMS integration and dining modes
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Bootstrapping logic for hotel PMS integration
    }
}
