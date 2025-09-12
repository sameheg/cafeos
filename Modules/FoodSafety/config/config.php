<?php

return [
    'feature_flags' => [
        'foodsafety_iot' => env('FOODSAFETY_IOT', false),
    ],
    'threshold' => [
        'min' => 0,
        'max' => 5,
    ],
];
