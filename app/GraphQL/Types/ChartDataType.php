<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ChartDataType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ChartData',
    ];

    public function fields(): array
    {
        return [
            'labels' => [
                'type' => Type::listOf(Type::string()),
            ],
            'datasets' => [
                'type' => Type::listOf(GraphQL::type('ChartDataset')),
            ],
        ];
    }
}
