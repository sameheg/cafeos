<?php

use App\Http\Middleware\AuditWebhookSignature;
use App\Http\Middleware\EnsureModuleEnabled;
use App\Http\Middleware\InitializeTenancyByDomain;
use App\Http\Middleware\SetSecurityHeaders;
use App\Http\Middleware\SetUserLocale;
use App\Http\Middleware\PrometheusMetricsMiddleware;
use App\Providers\ModuleServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        ModuleServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'tenancy' => InitializeTenancyByDomain::class,
            'module' => EnsureModuleEnabled::class,
            'webhook.signed' => AuditWebhookSignature::class,
        ]);
        $middleware->append(PrometheusMetricsMiddleware::class);
        $middleware->append(SetUserLocale::class);
        $middleware->append(SetSecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
