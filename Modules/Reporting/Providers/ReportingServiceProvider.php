<?php

namespace Modules\Reporting\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Reporting\Services\ForecastService;

class ReportingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ForecastService::class, function () {
            return new ForecastService();
        });
    }
}
