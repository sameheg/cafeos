<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('API-TOKEN');
        if (! $token) {
            abort(401, 'API token missing');
        }

        $record = ApiToken::where('token', $token)->first();
        if (! $record || ($record->expires_at && $record->expires_at->isPast())) {
            abort(401, 'Invalid API token');
        }

        $request->attributes->set('api_token', $record);
        return $next($request);
    }
}
