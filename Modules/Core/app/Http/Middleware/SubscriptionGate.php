<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionGate
{
    public function handle(Request $request, Closure $next)
    {
        $tenant = app('currentTenant');
        if ($tenant && $tenant->status !== 'active') {
            return response()->json(['message' => 'subscription_required'], Response::HTTP_PAYMENT_REQUIRED);
        }

        return $next($request);
    }
}
