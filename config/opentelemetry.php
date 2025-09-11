<?php

use Illuminate\Support\Str;
use Keepsuit\LaravelOpenTelemetry\Instrumentation;
use OpenTelemetry\SDK\Common\Configuration\Variables;

return [
    'service_name' => env(Variables::OTEL_SERVICE_NAME, Str::slug((string) env('APP_NAME', 'cafeos'))),
    'propagators' => env(Variables::OTEL_PROPAGATORS, 'tracecontext'),
    'traces' => [
        'exporter' => env(Variables::OTEL_TRACES_EXPORTER, 'null'),
        'sampler' => [
            'parent' => env('OTEL_TRACES_SAMPLER_PARENT', true),
            'type' => env('OTEL_TRACES_SAMPLER_TYPE', 'always_off'),
            'args' => [
                'ratio' => env('OTEL_TRACES_SAMPLER_TRACEIDRATIO_RATIO', 0.05),
            ],
        ],
    ],
    'logs' => [
        'exporter' => env(Variables::OTEL_LOGS_EXPORTER, 'null'),
        'inject_trace_id' => true,
        'trace_id_field' => 'traceid',
    ],
    'exporters' => [
        'otlp' => [
            'driver' => 'otlp',
            'endpoint' => env(Variables::OTEL_EXPORTER_OTLP_ENDPOINT, 'http://localhost:4318'),
            'protocol' => env(Variables::OTEL_EXPORTER_OTLP_PROTOCOL, 'http/protobuf'),
            'max_retries' => env('OTEL_EXPORTER_OTLP_MAX_RETRIES', 3),
        ],
        'console' => [
            'driver' => 'console',
        ],
        'null' => [
            'driver' => 'null',
        ],
    ],
    'instrumentation' => [
        Instrumentation\HttpServerInstrumentation::class => ['enabled' => env('OTEL_INSTRUMENTATION_HTTP_SERVER', true)],
        Instrumentation\HttpClientInstrumentation::class => ['enabled' => env('OTEL_INSTRUMENTATION_HTTP_CLIENT', true)],
        Instrumentation\QueryInstrumentation::class => env('OTEL_INSTRUMENTATION_QUERY', true),
        Instrumentation\RedisInstrumentation::class => env('OTEL_INSTRUMENTATION_REDIS', true),
        Instrumentation\QueueInstrumentation::class => env('OTEL_INSTRUMENTATION_QUEUE', true),
        Instrumentation\CacheInstrumentation::class => env('OTEL_INSTRUMENTATION_CACHE', true),
        Instrumentation\EventInstrumentation::class => [
            'enabled' => env('OTEL_INSTRUMENTATION_EVENT', true),
            'ignored' => [],
        ],
        Instrumentation\ViewInstrumentation::class => env('OTEL_INSTRUMENTATION_VIEW', true),
        Instrumentation\LivewireInstrumentation::class => env('OTEL_INSTRUMENTATION_LIVEWIRE', true),
        Instrumentation\ConsoleInstrumentation::class => [
            'enabled' => env('OTEL_INSTRUMENTATION_CONSOLE', true),
            'excluded' => [],
        ],
    ],
];
