<?php

namespace App\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Spatie\Multitenancy\MultitenancyServiceProvider;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;
use Spatie\Multitenancy\TenantFinder\DomainTenantFinder;
use App\Http\Middleware\InitializeTenant;
use App\Models\Tenant;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register Spatie's multitenancy provider
        $this->app->register(MultitenancyServiceProvider::class);

        // Bind the domain/subdomain based tenant resolver
        $this->app->singleton(TenantFinder::class, function () {
            return new DomainTenantFinder();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(Kernel $kernel): void
    {
        // Tell package to use our Tenant model
        BaseTenant::useModel(Tenant::class);

        // Register tenant-aware middleware globally
        $kernel->pushMiddleware(InitializeTenant::class);
    }
}
