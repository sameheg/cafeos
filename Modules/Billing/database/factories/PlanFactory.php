<?php

namespace Modules\Billing\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Billing\Models\Plan;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->unique()->slug(),
            'stripe_price_id' => $this->faker->uuid(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'trial_days' => $this->faker->numberBetween(0, 30),
            'modules' => [],
        ];
    }
}
