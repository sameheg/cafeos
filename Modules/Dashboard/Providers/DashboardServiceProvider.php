<?php

namespace Modules\Dashboard\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = __DIR__ . '/../';

        if (is_dir($modulePath . 'resources/views')) {
            $this->loadViewsFrom($modulePath . 'resources/views', 'dashboard');
            Blade::anonymousComponentPath($modulePath . 'resources/views', 'dashboard');
            if (is_dir($modulePath . 'resources/views/components')) {
                Blade::anonymousComponentPath($modulePath . 'resources/views/components', 'dashboard');
            }
        }

        if (is_dir($modulePath . 'resources/lang')) {
            $this->loadTranslationsFrom($modulePath . 'resources/lang', 'dashboard');
        }

        if (file_exists($modulePath . 'routes/web.php')) {
            $this->loadRoutesFrom($modulePath . 'routes/web.php');
        }

        if (file_exists($modulePath . 'routes/api.php')) {
            $this->loadRoutesFrom($modulePath . 'routes/api.php');
        }

        Blade::componentNamespace('Modules\\Dashboard\\View\\Components', 'dashboard');
    }
}
