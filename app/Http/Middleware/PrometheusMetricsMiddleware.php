<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Throwable;

class PrometheusMetricsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);

        try {
            $response = $next($request);
            $duration = microtime(true) - $start;

            if (class_exists(\Spatie\Prometheus\Facades\Prometheus::class)) {
                \Spatie\Prometheus\Facades\Prometheus::histogram(
                    'http_response_time_seconds',
                    'HTTP response time in seconds',
                    ['method', 'path']
                )->observe($duration, [$request->method(), $request->path()]);

                \Spatie\Prometheus\Facades\Prometheus::counter(
                    'http_requests_total',
                    'Total HTTP requests',
                    ['method', 'path', 'status']
                )->inc([$request->method(), $request->path(), $response->getStatusCode()]);
            }

            return $response;
        } catch (Throwable $e) {
            if (class_exists(\Spatie\Prometheus\Facades\Prometheus::class)) {
                \Spatie\Prometheus\Facades\Prometheus::counter(
                    'http_request_errors_total',
                    'Total HTTP request errors',
                    ['method', 'path']
                )->inc([$request->method(), $request->path()]);
            }

            throw $e;
        }
    }
}
