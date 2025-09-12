<?php

namespace Modules\Billing\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $module = 'Billing';

    public function map(): void
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes(): void
    {
        Route::middleware('api')
            ->prefix('api/v1/billing')
            ->group(module_path($this->module, '/routes/api.php'));
    }
}
