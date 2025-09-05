<?php

return [
    'providers' => [
        'talabat' => [
            'client_id' => env('TALABAT_CLIENT_ID'),
            'client_secret' => env('TALABAT_CLIENT_SECRET'),
            'base_uri' => env('TALABAT_BASE_URI', 'https://api.talabat.com'),
        ],
        'ubereats' => [
            'client_id' => env('UBEREATS_CLIENT_ID'),
            'client_secret' => env('UBEREATS_CLIENT_SECRET'),
            'base_uri' => env('UBEREATS_BASE_URI', 'https://api.ubereats.com'),
        ],
    ],
];
