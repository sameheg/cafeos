<?php

namespace Modules\QrOrdering\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class QrOrderingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = __DIR__.'/../';

        if (is_dir($modulePath.'resources/views')) {
            $this->loadViewsFrom($modulePath.'resources/views', 'qrordering');
            Blade::anonymousComponentPath($modulePath.'resources/views', 'qrordering');
            if (is_dir($modulePath.'resources/views/components')) {
                Blade::anonymousComponentPath($modulePath.'resources/views/components', 'qrordering');
            }
        }

        if (is_dir($modulePath.'resources/lang')) {
            $this->loadTranslationsFrom($modulePath.'resources/lang', 'qrordering');
        }

        if (file_exists($modulePath.'routes/web.php')) {
            $this->loadRoutesFrom($modulePath.'routes/web.php');
        }

        if (file_exists($modulePath.'routes/api.php')) {
            $this->loadRoutesFrom($modulePath.'routes/api.php');
        }

        Blade::componentNamespace('Modules\\QrOrdering\\View\\Components', 'qrordering');
    }
}
