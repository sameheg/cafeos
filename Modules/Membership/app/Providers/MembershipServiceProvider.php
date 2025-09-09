<?php

namespace Modules\Membership\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Membership\Contracts\LoyaltyServiceInterface;
use Modules\Membership\Services\LoyaltyService;

class MembershipServiceProvider extends ServiceProvider
{
    protected string $name = 'Membership';
    protected string $nameLower = 'membership';

    public function boot(): void
    {
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
    }

    public function register(): void
    {
        $this->app->bind(LoyaltyServiceInterface::class, LoyaltyService::class);
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->name, 'config/config.php') => config_path($this->nameLower . '.php'),
        ], 'config');

        $this->mergeConfigFrom(
            module_path($this->name, 'config/config.php'),
            $this->nameLower
        );
    }
}
