<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Models\Audit;

class AuditAction
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $tenant = app('currentTenant');
        Audit::create([
            'tenant_id' => $tenant?->id,
            'user_id' => $request->user()?->id,
            'action' => $request->method(),
            'path' => $request->path(),
        ]);

        return $response;
    }
}
