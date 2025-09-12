<?php

namespace Modules\EquipmentLeasing\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        Route::middleware('api')
            ->prefix('')
            ->group(module_path('EquipmentLeasing', '/routes/api.php'));
    }
}

