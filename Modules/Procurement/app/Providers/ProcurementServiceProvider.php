<?php

namespace Modules\Procurement\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\InventoryServiceInterface;
use Modules\Procurement\Services\PurchaseOrderService;

class ProcurementServiceProvider extends ServiceProvider
{
    protected string $name = 'Procurement';

    protected string $nameLower = 'procurement';

    public function boot(): void
    {
        $this->registerTranslations();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
    }

    public function register(): void
    {
        $this->app->singleton(PurchaseOrderService::class, function ($app) {
            return new PurchaseOrderService($app->make(InventoryServiceInterface::class));
        });
    }

    protected function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }
}
