<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocaleFromTenant
{
    public function handle(Request $request, Closure $next)
    {
        $tenant = app()->has('currentTenant') ? app('currentTenant') : null;

        if ($tenant && $tenant->locale) {
            app()->setLocale($tenant->locale);
        }

        return $next($request);
    }
}
