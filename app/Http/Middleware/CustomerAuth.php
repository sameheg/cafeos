<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class CustomerAuth
{
    public function handle(Request $request, Closure $next)
    {
        $auth = $request->header('Authorization');
        if (!$auth || !preg_match('/Bearer\s+(.*)$/i', $auth, $matches)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $token = $matches[1];
            $decoded = JWT::decode($token, new Key(env('CUSTOMER_JWT_SECRET', config('app.key')), 'HS256'));
            $request->attributes->set('customer_id', $decoded->sub ?? null);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
