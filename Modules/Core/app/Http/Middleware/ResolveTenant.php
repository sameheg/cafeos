<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Modules\Core\Models\Tenant;

class ResolveTenant
{
    public function handle($request, Closure $next)
    {
        $identifier = $request->header('X-Tenant');

        if (! $identifier) {
            $identifier = $request->getHost();
        }

        $tenant = Tenant::query()
            ->where('slug', $identifier)
            ->orWhereHas('domains', fn ($q) => $q->where('domain', $identifier))
            ->first();

        if (! $tenant) {
            abort(404, 'Tenant not found');
        }

        app()->instance('currentTenant', $tenant);

        return $next($request);
    }
}
