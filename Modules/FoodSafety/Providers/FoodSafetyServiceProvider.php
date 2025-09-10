<?php

namespace Modules\FoodSafety\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FoodSafetyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = __DIR__ . '/../';

        if (is_dir($modulePath . 'resources/views')) {
            $this->loadViewsFrom($modulePath . 'resources/views', 'foodsafety');
            Blade::anonymousComponentPath($modulePath . 'resources/views', 'foodsafety');
            if (is_dir($modulePath . 'resources/views/components')) {
                Blade::anonymousComponentPath($modulePath . 'resources/views/components', 'foodsafety');
            }
        }

        if (is_dir($modulePath . 'resources/lang')) {
            $this->loadTranslationsFrom($modulePath . 'resources/lang', 'foodsafety');
        }

        if (file_exists($modulePath . 'routes/web.php')) {
            $this->loadRoutesFrom($modulePath . 'routes/web.php');
        }

        if (file_exists($modulePath . 'routes/api.php')) {
            $this->loadRoutesFrom($modulePath . 'routes/api.php');
        }

        Blade::componentNamespace('Modules\\FoodSafety\\View\\Components', 'foodsafety');
    }
}
