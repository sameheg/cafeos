<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\InitializeTenancyByDomain;
use App\Http\Middleware\SetUserLocale;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'tenancy' => InitializeTenancyByDomain::class,
        ]);
        $middleware->append(SetUserLocale::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
