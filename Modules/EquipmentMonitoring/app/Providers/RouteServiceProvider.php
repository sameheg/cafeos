<?php

namespace Modules\EquipmentMonitoring\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__.'/../../routes/api.php');
    }
}
