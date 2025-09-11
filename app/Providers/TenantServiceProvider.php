<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Multitenancy\MultitenancyServiceProvider;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\DomainTenantFinder;
use App\Http\Middleware\InitializeTenant;

class TenantServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(MultitenancyServiceProvider::class);
    }

    public function boot(): void
    {
        Tenant::setTenantFinder(new DomainTenantFinder);

        $router = $this->app['router'];
        $router->middlewareGroup('tenant', [InitializeTenant::class]);
    }
}
