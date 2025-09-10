<?php

namespace Modules\Rentals\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RentalsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = __DIR__ . '/../';

        if (is_dir($modulePath . 'resources/views')) {
            $this->loadViewsFrom($modulePath . 'resources/views', 'rentals');
            Blade::anonymousComponentPath($modulePath . 'resources/views', 'rentals');
            if (is_dir($modulePath . 'resources/views/components')) {
                Blade::anonymousComponentPath($modulePath . 'resources/views/components', 'rentals');
            }
        }

        if (is_dir($modulePath . 'resources/lang')) {
            $this->loadTranslationsFrom($modulePath . 'resources/lang', 'rentals');
        }

        if (file_exists($modulePath . 'routes/web.php')) {
            $this->loadRoutesFrom($modulePath . 'routes/web.php');
        }

        if (file_exists($modulePath . 'routes/api.php')) {
            $this->loadRoutesFrom($modulePath . 'routes/api.php');
        }

        Blade::componentNamespace('Modules\\Rentals\\View\\Components', 'rentals');
    }
}
