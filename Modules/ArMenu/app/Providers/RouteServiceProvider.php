<?php

namespace Modules\ArMenu\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(__DIR__.'/../../routes/api.php');

            Route::middleware('web')
                ->group(__DIR__.'/../../routes/web.php');
        });
    }
}
