<?php

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateOrderMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createOrder',
    ];

    public function type(): Type
    {
        return GraphQL::type('Order');
    }

    public function args(): array
    {
        return [
            'status' => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        return [
            'id' => 1,
            'status' => $args['status'] ?? 'pending',
        ];
    }
}
