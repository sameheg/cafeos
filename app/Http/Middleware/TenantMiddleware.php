<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\TenantContext;
use Closure;
use Illuminate\Http\Request;

class TenantMiddleware
{
    public function __construct(private TenantContext $tenantContext)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $tenant = null;

        if ($uuid = $request->route('tenantUuid')) {
            $tenant = Tenant::where('uuid', $uuid)->first();
        }

        if (! $tenant) {
            $host = $request->getHost();
            $tenant = Tenant::where('domain', $host)->first();
        }

        if ($tenant) {
            $this->tenantContext->setTenant($tenant);
        }

        return $next($request);
    }
}

