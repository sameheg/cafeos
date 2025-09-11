<?php

return [
    'default' => env('QUEUE_CONNECTION', 'sync'),

    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CONNECTION', 'mysql'),
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],

        'tenant' => [
            'driver' => 'database',
            'connection' => env('TENANCY_DATABASE_CONNECTION', 'tenant'),
            'table' => 'jobs',
            'queue' => 'tenant',
            'retry_after' => 90,
        ],
    ],

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],
];
