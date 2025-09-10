<?php

namespace Modules\EquipmentMonitoring\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class EquipmentMonitoringServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = __DIR__.'/../';

        if (is_dir($modulePath.'resources/views')) {
            $this->loadViewsFrom($modulePath.'resources/views', 'equipmentmonitoring');
            Blade::anonymousComponentPath($modulePath.'resources/views', 'equipmentmonitoring');
            if (is_dir($modulePath.'resources/views/components')) {
                Blade::anonymousComponentPath($modulePath.'resources/views/components', 'equipmentmonitoring');
            }
        }

        if (is_dir($modulePath.'resources/lang')) {
            $this->loadTranslationsFrom($modulePath.'resources/lang', 'equipmentmonitoring');
        }

        if (file_exists($modulePath.'routes/web.php')) {
            $this->loadRoutesFrom($modulePath.'routes/web.php');
        }

        if (file_exists($modulePath.'routes/api.php')) {
            $this->loadRoutesFrom($modulePath.'routes/api.php');
        }

        Blade::componentNamespace('Modules\\EquipmentMonitoring\\View\\Components', 'equipmentmonitoring');
    }
}
