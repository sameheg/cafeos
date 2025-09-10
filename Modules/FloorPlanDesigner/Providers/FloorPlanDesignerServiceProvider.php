<?php

namespace Modules\FloorPlanDesigner\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FloorPlanDesignerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = __DIR__ . '/../';

        if (is_dir($modulePath . 'resources/views')) {
            $this->loadViewsFrom($modulePath . 'resources/views', 'floorplandesigner');
            Blade::anonymousComponentPath($modulePath . 'resources/views', 'floorplandesigner');
            if (is_dir($modulePath . 'resources/views/components')) {
                Blade::anonymousComponentPath($modulePath . 'resources/views/components', 'floorplandesigner');
            }
        }

        if (is_dir($modulePath . 'resources/lang')) {
            $this->loadTranslationsFrom($modulePath . 'resources/lang', 'floorplandesigner');
        }

        if (file_exists($modulePath . 'routes/web.php')) {
            $this->loadRoutesFrom($modulePath . 'routes/web.php');
        }

        if (file_exists($modulePath . 'routes/api.php')) {
            $this->loadRoutesFrom($modulePath . 'routes/api.php');
        }

        Blade::componentNamespace('Modules\\FloorPlanDesigner\\View\\Components', 'floorplandesigner');
    }
}
