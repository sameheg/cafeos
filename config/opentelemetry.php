<?php

return [
    'endpoint' => env('OTEL_EXPORTER_OTLP_ENDPOINT', 'http://localhost:4318'),
    'disabled' => env('OTEL_SDK_DISABLED', false),
];
