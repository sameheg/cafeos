<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ChartDatasetType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ChartDataset',
    ];

    public function fields(): array
    {
        return [
            'label' => [
                'type' => Type::string(),
            ],
            'data' => [
                'type' => Type::listOf(Type::float()),
            ],
        ];
    }
}
