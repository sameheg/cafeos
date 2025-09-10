<?php

namespace App\Http\Middleware;

use Closure;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;
use Prometheus\Storage\Redis as RedisStorage;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PrometheusMetricsMiddleware
{
    private ?CollectorRegistry $registry = null;

    private function registry(): CollectorRegistry
    {
        if ($this->registry !== null) {
            return $this->registry;
        }

        $driver = config('services.prometheus_storage', 'memory');

        if ($driver === 'redis' && extension_loaded('redis')) {
            try {
                $config = config('database.redis.default');
                $adapter = new RedisStorage([
                    'host' => $config['host'] ?? '127.0.0.1',
                    'port' => $config['port'] ?? 6379,
                    'password' => $config['password'] ?? null,
                    'database' => $config['database'] ?? 0,
                ]);
            } catch (Throwable $e) {
                $adapter = new InMemory;
            }
        } else {
            $adapter = new InMemory;
        }

        return $this->registry = new CollectorRegistry($adapter);
    }

    public function handle($request, Closure $next)
    {
        $registry = $this->registry();

        $counter = $registry->getOrRegisterCounter(
            'app',
            'http_requests_total',
            'HTTP request count',
            ['method', 'path', 'status']
        );

        $histogram = $registry->getOrRegisterHistogram(
            'app',
            'http_request_duration_seconds',
            'HTTP request duration',
            ['method', 'path', 'status']
        );

        $start = microtime(true);

        /** @var Response $response */
        $response = $next($request);

        $labels = [
            $request->getMethod(),
            $request->route()?->uri() ?? 'unknown',
            (string) $response->getStatusCode(),
        ];

        $counter->inc($labels);
        $histogram->observe(microtime(true) - $start, $labels);

        return $response;
    }
}
