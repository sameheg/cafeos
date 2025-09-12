<?php
return [
    'strict_reservation_guard' => true,
    'hardware' => [
        'driver' => env('POS_PRINTER_DRIVER', 'log'), // log|escpos
        'printer_uri' => env('POS_PRINTER_URI', 'tcp://192.168.1.50:9100'),
    ],
    'offline_sync' => [
        'enabled' => true,
        'allow_roles' => ['Owner','Manager'],
    ],
];
