<?php

namespace Modules\SelfServiceKiosk\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->prefix('kiosk')
                ->group(module_path('SelfServiceKiosk', 'routes/web.php'));

            Route::middleware('api')
                ->prefix('api/kiosk')
                ->group(module_path('SelfServiceKiosk', 'routes/api.php'));
        });
    }
}
