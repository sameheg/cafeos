<?php

namespace App\GraphQL\Queries;

use App\Charts\SalesTrendChart;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class SalesTrendChartQuery extends Query
{
    protected $attributes = [
        'name' => 'salesTrend',
    ];

    public function type(): Type
    {
        return GraphQL::type('ChartData');
    }

    public function args(): array
    {
        return [
            'start_date' => ['type' => Type::string()],
            'end_date' => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $chart = new SalesTrendChart();

        return $chart->data($args);
    }
}
