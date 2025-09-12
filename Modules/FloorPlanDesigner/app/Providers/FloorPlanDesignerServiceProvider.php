<?php

namespace Modules\FloorPlanDesigner\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Modules\FloorPlanDesigner\Observers\FloorplanObserver;

class FloorPlanDesignerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'floorplandesigner');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'floorplandesigner');
        Floorplan::observe(FloorplanObserver::class);
    }
}
