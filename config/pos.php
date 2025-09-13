<?php

return [
    /*
    |--------------------------------------------------------------------------
    | POS Defaults
    |--------------------------------------------------------------------------
    |
    | Default configuration for the Point of Sale system. Tenants may override
    | these settings via the `settings->pos` JSON column in the database.
    */

    'kds' => [
        'enabled' => false,
        'auto_bump' => false,
    ],

    'loyalty' => [
        'enabled' => false,
        'points_per_currency' => 1,
    ],

    'theme' => [
        'name' => 'default',
        'primary_color' => '#000000',
        'secondary_color' => '#ffffff',
    ],

    'device' => [
        'label' => 'POS',
        'sleep_timeout' => 300,
    ],
];
