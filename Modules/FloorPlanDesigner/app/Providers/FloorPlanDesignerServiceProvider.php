<?php

namespace Modules\FloorPlanDesigner\Providers;

use Illuminate\Support\ServiceProvider;

class FloorPlanDesignerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'floor-plan-designer');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('floor-plan-designer.php'),
        ], 'config');
    }
}

