<?php

namespace Modules\SuperAdmin\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SuperAdminServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = __DIR__ . '/../';

        if (is_dir($modulePath . 'resources/views')) {
            $this->loadViewsFrom($modulePath . 'resources/views', 'superadmin');
            Blade::anonymousComponentPath($modulePath . 'resources/views', 'superadmin');
            if (is_dir($modulePath . 'resources/views/components')) {
                Blade::anonymousComponentPath($modulePath . 'resources/views/components', 'superadmin');
            }
        }

        if (is_dir($modulePath . 'resources/lang')) {
            $this->loadTranslationsFrom($modulePath . 'resources/lang', 'superadmin');
        }

        if (file_exists($modulePath . 'routes/web.php')) {
            $this->loadRoutesFrom($modulePath . 'routes/web.php');
        }

        if (file_exists($modulePath . 'routes/api.php')) {
            $this->loadRoutesFrom($modulePath . 'routes/api.php');
        }

        Blade::componentNamespace('Modules\\SuperAdmin\\View\\Components', 'superadmin');
    }
}
