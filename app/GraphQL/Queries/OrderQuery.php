<?php

namespace App\GraphQL\Queries;

use App\Transaction;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class OrderQuery extends Query
{
    protected $attributes = [
        'name' => 'order',
    ];

    public function type(): Type
    {
        return GraphQL::type('Order');
    }

    public function args(): array
    {
        return [
            'id' => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return Transaction::find($args['id']);
        }
        return Transaction::first();
    }
}
