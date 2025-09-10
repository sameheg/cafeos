<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\DeliveryAggregator;
use App\Services\DeliveryAggregators\TalabatService;

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
        //
    }
}
