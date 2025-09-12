<?php

namespace Modules\FloorPlanDesigner\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'FloorPlanDesigner';

    public function map(): void
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes(): void
    {
        Route::middleware('api')
            ->prefix('api/v1/floorplan')
            ->name('api.floorplan.')
            ->group(module_path($this->moduleName, '/routes/api.php'));
    }
}
