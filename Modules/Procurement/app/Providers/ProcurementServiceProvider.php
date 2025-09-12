<?php

namespace Modules\Procurement\Providers;

use Illuminate\Support\ServiceProvider;

class ProcurementServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('Procurement', 'database/migrations'));
        // Placeholder for observers or boot logic
    }
}
