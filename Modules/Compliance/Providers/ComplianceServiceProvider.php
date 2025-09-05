<?php

namespace Modules\Compliance\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Compliance\Services\EInvoiceService;
use Modules\Compliance\Services\TaxEngine;

class ComplianceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(EInvoiceService::class, fn () => new EInvoiceService());
        $this->app->singleton(TaxEngine::class, fn () => new TaxEngine());
    }

    public function boot(): void
    {
        // In a full implementation, migrations and routes would be loaded here
    }
}
