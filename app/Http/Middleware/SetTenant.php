<?php

namespace App\Http\Middleware;

use App\Tenant;
use Closure;
use Illuminate\Support\Str;

class SetTenant
{
    public function handle($request, Closure $next)
    {
        $identifier = $request->header('X-Tenant-ID')
            ?? $request->header('X-Tenant');

        if (! $identifier) {
            $host = $request->getHost();
            $parts = explode('.', $host);
            if (count($parts) > 2) {
                $identifier = $parts[0];
            }
        }

        if ($identifier) {
            $identifier = Str::lower($identifier);

            $tenant = Tenant::where('id', $identifier)
                ->orWhere('slug', $identifier)
                ->first();

            if ($tenant) {
                app()->instance('tenant', $tenant);
            }
        }

        return $next($request);
    }
}
