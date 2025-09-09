<?php

namespace Modules\FloorPlanDesigner\Providers;

use Illuminate\Support\ServiceProvider;

class FloorPlanDesignerServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'FloorPlanDesigner';
    protected string $moduleNameLower = 'floor-plan-designer';

    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
    }

    public function boot(): void
    {
        $this->registerTranslations();
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'floor-plan-designer');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('floor-plan-designer.php'),
        ], 'config');
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

