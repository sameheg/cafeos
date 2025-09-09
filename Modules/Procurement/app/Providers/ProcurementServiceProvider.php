<?php

namespace Modules\Procurement\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Procurement\Services\PurchaseOrderService;
use Modules\Core\Contracts\InventoryServiceInterface;

class ProcurementServiceProvider extends ServiceProvider
{
    protected string $name = 'Procurement';
    protected string $nameLower = 'procurement';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
    }

    public function register(): void
    {
        $this->app->singleton(PurchaseOrderService::class, function ($app) {
            return new PurchaseOrderService($app->make(InventoryServiceInterface::class));
        });
    }
}

