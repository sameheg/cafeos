<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Models\Tenant;
use Modules\Core\Support\EventBus;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0] ?? null;

        if ($subdomain) {
            $tenant = Tenant::where('subdomain', $subdomain)->first();
            if (!$tenant) {
                return redirect('/')->with('error', 'Tenant not found');
            }
            app()->instance('tenant', $tenant);
            $request->attributes->set('tenant_id', $tenant->id);
            EventBus::emit('core.tenant.resolved@v1', ['tenant_id' => $tenant->id]);
        }

        return $next($request);
    }
}
