<?php

namespace Modules\QrOrdering\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->prefix('qr-ordering')
                ->group(module_path('QrOrdering', 'routes/web.php'));

            Route::middleware('api')
                ->prefix('api/qr-ordering')
                ->group(module_path('QrOrdering', 'routes/api.php'));
        });
    }
}
