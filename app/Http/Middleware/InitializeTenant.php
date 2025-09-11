<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;

class InitializeTenant
{
    public function handle($request, Closure $next)
    {
        $domain = $request->getHost();
        $tenant = Tenant::where('domain', $domain)->first();

        if ($tenant) {
            $tenant->makeCurrent();
        }

        return $next($request);
    }
}
