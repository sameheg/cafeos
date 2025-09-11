<?php

namespace Modules\Core\Http\Middleware;

use Closure;

class EnsureModuleEnabled
{
    public function handle($request, Closure $next, string $module)
    {
        $tenant = app()->bound('currentTenant') ? app('currentTenant') : null;

        if ($tenant && ! $tenant->modules()->where('module', $module)->where('enabled', true)->exists()) {
            abort(403, 'Module disabled');
        }

        return $next($request);
    }
}
