<?php

namespace Modules\Pos\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class Idempotency
{
    public function handle($request, Closure $next)
    {
        $key = $request->header('Idempotency-Key');
        if (!$key) return $next($request);
        $cacheKey = 'idem:'.$key;
        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }
        $response = $next($request);
        if ($response->status() >= 200 && $response->status() < 300) {
            Cache::put($cacheKey, $response->getData(true), now()->addMinutes(10));
        }
        return $response;
    }
}
