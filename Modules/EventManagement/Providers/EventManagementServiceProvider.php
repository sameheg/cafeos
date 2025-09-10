<?php

namespace Modules\EventManagement\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class EventManagementServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = __DIR__.'/../';

        if (is_dir($modulePath.'resources/views')) {
            $this->loadViewsFrom($modulePath.'resources/views', 'eventmanagement');
            Blade::anonymousComponentPath($modulePath.'resources/views', 'eventmanagement');
            if (is_dir($modulePath.'resources/views/components')) {
                Blade::anonymousComponentPath($modulePath.'resources/views/components', 'eventmanagement');
            }
        }

        if (is_dir($modulePath.'resources/lang')) {
            $this->loadTranslationsFrom($modulePath.'resources/lang', 'eventmanagement');
        }

        if (file_exists($modulePath.'routes/web.php')) {
            $this->loadRoutesFrom($modulePath.'routes/web.php');
        }

        if (file_exists($modulePath.'routes/api.php')) {
            $this->loadRoutesFrom($modulePath.'routes/api.php');
        }

        Blade::componentNamespace('Modules\\EventManagement\\View\\Components', 'eventmanagement');
    }
}
