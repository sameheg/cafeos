<?php

return [
    'schemas' => [
        'default' => [
            'query' => [
                'product' => \App\GraphQL\Queries\ProductQuery::class,
                'order' => \App\GraphQL\Queries\OrderQuery::class,
                'salesTrend' => \App\GraphQL\Queries\SalesTrendChartQuery::class,
                'topItems' => \App\GraphQL\Queries\TopItemsChartQuery::class,
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
        'ChartData' => \App\GraphQL\Types\ChartDataType::class,
        'ChartDataset' => \App\GraphQL\Types\ChartDatasetType::class,
    ],
];
