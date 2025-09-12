<?php

namespace Modules\FloorPlanDesigner\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Modules\FloorPlanDesigner\Observers\FloorplanObserver;
use Illuminate\Support\Facades\Gate;
use Modules\FloorPlanDesigner\Models\Floorplan as FloorplanModel;
use Modules\FloorPlanDesigner\Models\FloorplanZone as FloorplanZoneModel;
use Modules\FloorPlanDesigner\Policies\FloorplanPolicy;
use Modules\FloorPlanDesigner\Policies\FloorplanZonePolicy;
use Modules\FloorPlanDesigner\Models\Furniture as FurnitureModel;
use Modules\FloorPlanDesigner\Policies\FurniturePolicy;

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
        Gate::policy(FloorplanModel::class, FloorplanPolicy::class);
        Gate::policy(FloorplanZoneModel::class, FloorplanZonePolicy::class);
        Gate::policy(FurnitureModel::class, FurniturePolicy::class);
    }
}
