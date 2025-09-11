<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Multitenancy\Models\Tenant;

class InitializeTenant
{
    public function handle($request, Closure $next)
    {
        $tenant = Tenant::where('domain', $request->getHost())->first();

        if ($tenant) {
            $tenant->makeCurrent();
        }

        return $next($request);
    }
}
