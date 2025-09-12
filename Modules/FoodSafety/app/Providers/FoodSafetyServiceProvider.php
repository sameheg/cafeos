<?php

namespace Modules\FoodSafety\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\FoodSafety\Models\FoodSafetyLog;
use Modules\FoodSafety\Observers\FoodSafetyLogObserver;
use Modules\FoodSafety\Services\ThresholdChecker;

class FoodSafetyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ThresholdChecker::class, function ($app) {
            $threshold = $app['config']['foodsafety.threshold'] ?? ['min' => 0, 'max' => 5];
            return new ThresholdChecker($threshold);
        });
    }

    public function boot(): void
    {
        FoodSafetyLog::observe(FoodSafetyLogObserver::class);
    }
}
