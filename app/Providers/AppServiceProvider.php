<?php

namespace App\Providers;

use App\Contracts\DeliveryAggregator;
use App\Services\DeliveryAggregators\TalabatService;
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
        //
    }
}
