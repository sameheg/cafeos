<?php

namespace App\Providers;

use App\Contracts\DeliveryAggregator;
use App\Services\DeliveryAggregators\TalabatService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DeliveryAggregator::class, TalabatService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(database_path('migrations/central'));

        if ($this->app->environment('local')) {
            Model::preventLazyLoading();

            Model::handleLazyLoadingViolationUsing(function ($model, string $relation): void {
                $message = 'N+1 detected: '.get_class($model).' -> '.$relation;

                if (function_exists('clock')) {
                    clock()->warning($message);
                }

                if (app()->bound('debugbar')) {
                    app('debugbar')->warning($message);
                }

                logger()->warning($message);
            });
        }
    }
}
