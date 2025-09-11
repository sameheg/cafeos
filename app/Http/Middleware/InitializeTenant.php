<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Multitenancy\TenantFinder\TenantFinder;
use Symfony\Component\HttpFoundation\Request;

class InitializeTenant
{
    public function __construct(protected TenantFinder $tenantFinder)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        if ($tenant = $this->tenantFinder->findForRequest($request)) {
            $tenant->makeCurrent();
        }

        return $next($request);
    }
}
