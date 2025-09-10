<?php

namespace Modules\HrJobs\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class HrJobsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $modulePath = __DIR__.'/../';

        if (is_dir($modulePath.'resources/views')) {
            $this->loadViewsFrom($modulePath.'resources/views', 'hrjobs');
            Blade::anonymousComponentPath($modulePath.'resources/views', 'hrjobs');
            if (is_dir($modulePath.'resources/views/components')) {
                Blade::anonymousComponentPath($modulePath.'resources/views/components', 'hrjobs');
            }
        }

        if (is_dir($modulePath.'resources/lang')) {
            $this->loadTranslationsFrom($modulePath.'resources/lang', 'hrjobs');
        }

        if (file_exists($modulePath.'routes/web.php')) {
            $this->loadRoutesFrom($modulePath.'routes/web.php');
        }

        if (file_exists($modulePath.'routes/api.php')) {
            $this->loadRoutesFrom($modulePath.'routes/api.php');
        }

        Blade::componentNamespace('Modules\\HrJobs\\View\\Components', 'hrjobs');
    }
}
