<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

use function app;
use function tenant;

class SetUserLocale
{
    public function handle(Request $request, Closure $next)
    {
        $tenantLocale = app()->has('tenant') ? app('tenant')->locale ?? null : tenant('locale');
        $locale = $request->query('lang')
            ?? session('locale')
            ?? ($request->user()->locale ?? $tenantLocale ?? config('app.locale'));

        session(['locale' => $locale]);
        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
