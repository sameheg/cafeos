<?php

namespace Modules\Superadmin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleNamespace = 'Modules\\Superadmin\\Http\\Controllers';

    public function map(): void
    {
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware(['web', 'auth', 'superadmin', 'tenantResolver'])
            ->namespace($this->moduleNamespace)
            ->prefix('superadmin')
            ->as('superadmin.')
            ->group(module_path('Superadmin', '/Routes/web.php'));
    }
}
