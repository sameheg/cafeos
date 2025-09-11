<?php

namespace App\Providers;

use App\Events\TenantCreated;
use App\Http\Middleware\InitializeTenant;
use App\Listeners\ProvisionTenantQueue;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Spatie\Multitenancy\TenantFinder\DomainTenantFinder;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        // Configure the domain based tenant finder
        config(['multitenancy.tenant_finder' => DomainTenantFinder::class]);

        // Register tenant middleware
        $router->aliasMiddleware('tenant', InitializeTenant::class);
        $router->pushMiddlewareToGroup('web', InitializeTenant::class);

        // Register event listeners
        Event::listen(TenantCreated::class, ProvisionTenantQueue::class);
    }
}
