<?php

return [
    'default' => env('BILLING_PROVIDER', 'stripe'),

    'providers' => [
        'stripe' => [
            'secret' => env('STRIPE_SECRET'),
            'public' => env('STRIPE_PUBLIC'),
        ],
        'paddle' => [
            'vendor_id' => env('PADDLE_VENDOR_ID'),
            'api_key' => env('PADDLE_API_KEY'),
        ],
    ],
];
