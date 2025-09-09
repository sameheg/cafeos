<?php

namespace Modules\Loyalty\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Loyalty\Contracts\LoyaltyServiceInterface;
use Modules\Loyalty\Services\LoyaltyService;

class LoyaltyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path('Loyalty', 'database/migrations'));
    }

    public function register(): void
    {
        $this->app->bind(LoyaltyServiceInterface::class, LoyaltyService::class);
    }
}
