<?php

return [
    'provider' => env('ACCOUNTING_PROVIDER', 'quickbooks'),
    'providers' => [
        'quickbooks' => App\Services\Accounting\QuickBooksService::class,
    ],
];
