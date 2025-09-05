<?php

namespace Modules\Superadmin\Providers;

use Illuminate\Support\ServiceProvider;

class SuperadminServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Superadmin';
    protected string $moduleNameLower = 'superadmin';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->loadViewsFrom(module_path($this->moduleName, 'Resources/views'), $this->moduleNameLower);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
