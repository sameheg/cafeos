<?php

namespace Modules\Reports\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ReportsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = __DIR__.'/../';

        if (is_dir($modulePath.'resources/views')) {
            $this->loadViewsFrom($modulePath.'resources/views', 'reports');
            Blade::anonymousComponentPath($modulePath.'resources/views', 'reports');
            if (is_dir($modulePath.'resources/views/components')) {
                Blade::anonymousComponentPath($modulePath.'resources/views/components', 'reports');
            }
        }

        if (is_dir($modulePath.'resources/lang')) {
            $this->loadTranslationsFrom($modulePath.'resources/lang', 'reports');
        }

        if (file_exists($modulePath.'routes/web.php')) {
            $this->loadRoutesFrom($modulePath.'routes/web.php');
        }

        if (file_exists($modulePath.'routes/api.php')) {
            $this->loadRoutesFrom($modulePath.'routes/api.php');
        }

        Blade::componentNamespace('Modules\\Reports\\View\\Components', 'reports');
    }
}
