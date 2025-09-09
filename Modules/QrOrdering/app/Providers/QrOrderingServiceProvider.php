<?php

namespace Modules\QrOrdering\Providers;

use Modules\QrOrdering\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class QrOrderingServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'QrOrdering';
    protected string $moduleNameLower = 'qr-ordering';

    public function boot(): void
    {
        $this->loadViewsFrom(module_path($this->moduleName, 'resources/views'), $this->moduleNameLower);
        $this->loadTranslationsFrom(module_path($this->moduleName, 'resources/lang'), $this->moduleNameLower);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
