<?php

namespace Modules\EquipmentMonitoring\Providers;

use Illuminate\Support\ServiceProvider;

class EquipmentMonitoringServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'EquipmentMonitoring';

    protected string $moduleNameLower = 'equipmentmonitoring';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
        $this->loadRoutesFrom(module_path($this->moduleName, 'routes/api.php'));
        $this->loadRoutesFrom(module_path($this->moduleName, 'routes/web.php'));
        $this->loadViewsFrom(module_path($this->moduleName, 'resources/views'), $this->moduleNameLower);
    }

    public function register(): void
    {
        //
    }
}
