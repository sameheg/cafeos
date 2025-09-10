<?php

return [
    'audit_log' => [
        // Location of append-only audit log file
        'file' => storage_path('logs/audit.log'),
        // Number of days to retain audit records to meet GDPR/PCI requirements
        'retention_days' => env('AUDIT_LOG_RETENTION_DAYS', 30),
    ],

    // Comma separated list of IP addresses allowed to access the application
    'ip_whitelist' => array_filter(explode(',', env('IP_WHITELIST', ''))),

    // Feature flag for multi-factor authentication support
    'mfa' => [
        'enabled' => env('MFA_ENABLED', false),
    ],

    // Placeholder configuration for post-quantum encryption algorithms
    'quantum_encryption' => [
        'enabled' => env('PQ_ENCRYPTION_ENABLED', false),
        'cipher' => env('PQ_CIPHER', 'kyber1024'),
    ],
];
