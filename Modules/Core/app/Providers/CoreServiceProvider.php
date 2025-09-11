<?php

namespace Modules\Core\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\TenantCreated;
use Modules\Core\Http\Middleware\AuditAction;
use Modules\Core\Http\Middleware\EnsureModuleEnabled;
use Modules\Core\Http\Middleware\ResolveTenant;
use Modules\Core\Http\Middleware\SetLocaleFromTenant;
use Modules\Core\Http\Middleware\SubscriptionGate;
use Modules\Core\Listeners\BootstrapTenant;
use Modules\Core\Listeners\RecordOutboxEvent;
use Spatie\Permission\Middleware\RoleMiddleware;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register bindings for the core module here
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->mergeConfigFrom(__DIR__.'/../../config/core.php', 'core');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'core');

        /** @var Router $router */
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('resolve-tenant', ResolveTenant::class);
        $router->aliasMiddleware('ensure-module-enabled', EnsureModuleEnabled::class);
        $router->aliasMiddleware('set-locale-from-tenant', SetLocaleFromTenant::class);
        $router->aliasMiddleware('audit', AuditAction::class);
        $router->aliasMiddleware('subscription-gate', SubscriptionGate::class);
        $router->aliasMiddleware('role', RoleMiddleware::class);

        Event::listen(TenantCreated::class, BootstrapTenant::class);
        Event::subscribe(RecordOutboxEvent::class);
    }
}
