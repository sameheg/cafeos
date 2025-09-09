<?php

namespace Modules\Pos\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Pos\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'tenant_id' => 1,
            'total' => $this->faker->randomFloat(2, 10, 100),
            'status' => 'open',
        ];
    }
}
