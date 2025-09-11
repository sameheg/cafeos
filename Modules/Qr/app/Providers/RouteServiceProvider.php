<?php

namespace Modules\Qr\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        Route::middleware('api')
            ->prefix('v1/qr')
            ->group(module_path('Qr', 'routes/api.php'));
    }
}
