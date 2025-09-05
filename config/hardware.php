<?php

return [
    'devices' => [
        'printer' => [
            'driver' => env('HARDWARE_PRINTER_DRIVER', 'FilePrintConnector'),
            'port' => env('HARDWARE_PRINTER_PORT', 'php://stdout'),
            'host' => env('HARDWARE_PRINTER_HOST', '127.0.0.1'),
        ],
    ],
];
