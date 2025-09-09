<?php

namespace Modules\Kds\Providers;

use Illuminate\Support\ServiceProvider;

class KdsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot(): void
    {
        $this->mergeConfigFrom(module_path('Kds', 'config/config.php'), 'kds');
        $this->loadMigrationsFrom(module_path('Kds', 'database/migrations'));
    }
}
