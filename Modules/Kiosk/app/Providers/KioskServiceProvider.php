<?php

namespace Modules\Kiosk\Providers;

use Illuminate\Support\ServiceProvider;

class KioskServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('Kiosk', 'database/migrations'));
        $this->loadViewsFrom(module_path('Kiosk', 'resources/views'), 'kiosk');
    }
}
