<?php

namespace Modules\POS\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Compliance\Services\EInvoiceService;
use Modules\POS\Services\InvoiceService;

class POSServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(InvoiceService::class, function ($app) {
            return new InvoiceService($app->make(EInvoiceService::class));
        });
    }

    public function boot(): void
    {
        // Boot logic for POS module
    }
}
