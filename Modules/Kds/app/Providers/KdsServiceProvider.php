<?php

namespace Modules\Kds\Providers;

use Illuminate\Support\ServiceProvider;

class KdsServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Kds';
    protected string $moduleNameLower = 'kds';

    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot(): void
    {
        $this->registerTranslations();
        $this->mergeConfigFrom(module_path('Kds', 'config/config.php'), 'kds');
        $this->loadMigrationsFrom(module_path('Kds', 'database/migrations'));
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
