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
        $this->registerTranslations();
        $this->loadViewsFrom(module_path($this->moduleName, 'resources/views'), $this->moduleNameLower);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
        }
    }
}
