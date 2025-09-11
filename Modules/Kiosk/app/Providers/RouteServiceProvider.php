<?php

namespace Modules\Kiosk\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        Route::middleware('api')
            ->prefix('v1/kiosk')
            ->group(module_path('Kiosk', 'routes/api.php'));
    }
}
