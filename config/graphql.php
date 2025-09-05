<?php

return [
    'schemas' => [
        'default' => [
            'query' => [
                'product' => \App\GraphQL\Queries\ProductQuery::class,
                'order' => \App\GraphQL\Queries\OrderQuery::class,
            ],
            'mutation' => [
                'createOrder' => \App\GraphQL\Mutations\CreateOrderMutation::class,
            ],
            'types' => [],
        ],
    ],
    'types' => [
        'Product' => \App\GraphQL\Types\ProductType::class,
        'Order' => \App\GraphQL\Types\OrderType::class,
    ],
];
