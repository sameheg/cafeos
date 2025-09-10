<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $checks = [];

        $checks['database'] = rescue(fn () => DB::connection()->getPdo(), false, false) !== false;
        $checks['queue'] = rescue(fn () => Redis::connection()->ping(), false, false) !== false;

        $wsUrl = config('services.ws.health_url');
        $checks['ws'] = $wsUrl ? rescue(fn () => Http::get($wsUrl)->ok(), false, false) : true;

        $heartbeat = Cache::get('scheduler:heartbeat');
        $checks['scheduler'] = $heartbeat && now()->diffInSeconds($heartbeat) < 300;

        $status = collect($checks)->every(fn ($value) => $value) ? 'ok' : 'degraded';

        return response()->json([
            'status' => $status,
            'checks' => $checks,
        ]);
    }
}
