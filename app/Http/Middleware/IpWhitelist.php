<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restrict access to requests originating from whitelisted IP addresses.
 */
class IpWhitelist
{
    public function handle(Request $request, Closure $next): Response
    {
        $whitelist = config('security.ip_whitelist');
        if (! empty($whitelist) && ! in_array($request->ip(), $whitelist, true)) {
            abort(403, 'IP address not allowed.');
        }

        return $next($request);
    }
}
