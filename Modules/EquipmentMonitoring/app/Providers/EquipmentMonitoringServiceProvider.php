<?php

namespace Modules\EquipmentMonitoring\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;

class EquipmentMonitoringServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'equipment-monitoring');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('equipment-monitoring.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        Feature::define('monitoring_iot_buffering', fn () => config('equipment-monitoring.features.monitoring_iot_buffering'));
    }
}
