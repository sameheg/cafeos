<?php

namespace Modules\Training\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schedule;
use Modules\Training\Console\Commands\CheckTrainingRefresher;

class TrainingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CheckTrainingRefresher::class,
            ]);
        }

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'training');
    }
}
