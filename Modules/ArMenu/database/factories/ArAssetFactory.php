<?php

namespace Modules\ArMenu\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ArMenu\Models\ArAsset;

class ArAssetFactory extends Factory
{
    protected $model = ArAsset::class;

    public function definition(): array
    {
        return [
            'tenant_id' => $this->faker->uuid(),
            'item_id' => (string) $this->faker->numberBetween(1, 9999),
            'url' => $this->faker->url(),
            'type' => 'ar',
            'state' => 'loaded',
        ];
    }
}
