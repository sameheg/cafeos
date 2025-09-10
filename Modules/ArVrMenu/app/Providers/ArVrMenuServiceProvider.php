<?php

namespace Modules\ArVrMenu\Providers;

use Illuminate\Support\ServiceProvider;

class ArVrMenuServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register bindings or configuration for AR/VR menu preview experiments
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Bootstrapping logic for AR/VR menu preview experiments
    }
}
