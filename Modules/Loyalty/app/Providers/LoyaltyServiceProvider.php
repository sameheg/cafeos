<?php

namespace Modules\Loyalty\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Loyalty\Contracts\LoyaltyServiceInterface;
use Modules\Loyalty\Services\LoyaltyService;

class LoyaltyServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Loyalty';

    protected string $moduleNameLower = 'loyalty';

    public function boot(): void
    {
        $this->registerTranslations();
        $this->loadMigrationsFrom(module_path('Loyalty', 'database/migrations'));
    }

    public function register(): void
    {
        $this->app->bind(LoyaltyServiceInterface::class, LoyaltyService::class);
    }

    protected function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'lang'));
        }
    }
}
