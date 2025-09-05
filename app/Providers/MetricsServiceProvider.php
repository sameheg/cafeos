<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class MetricsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->make(Kernel::class)->pushMiddleware(\App\Http\Middleware\PrometheusMetricsMiddleware::class);
    }
}
