<?php

namespace App\GraphQL\Queries;

use App\Charts\TopItemsChart;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TopItemsChartQuery extends Query
{
    protected $attributes = [
        'name' => 'topItems',
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
            'limit' => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $chart = new TopItemsChart();

        return $chart->data($args);
    }
}
