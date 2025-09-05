<?php

namespace App\GraphQL\Queries;

use App\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ProductQuery extends Query
{
    protected $attributes = [
        'name' => 'product',
    ];

    public function type(): Type
    {
        return GraphQL::type('Product');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Identifier of the product.',
            ],
        ];
    }

    public function resolve($root, array $args)
    {
        return Product::find($args['id']);
    }
}
