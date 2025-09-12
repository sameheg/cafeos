<?php

namespace Modules\FloorPlanDesigner\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\FloorPlanDesigner\Models\FloorplanZone;
use Modules\FloorPlanDesigner\Models\Floorplan;

class FloorplanZoneFactory extends Factory
{
    protected $model = FloorplanZone::class;

    public function definition(): array
    {
        return [
            'tenant_id' => $this->faker->uuid(),
            'plan_id' => Floorplan::factory(),
            'name' => $this->faker->unique()->word(),
            'coords' => [['x' => 10, 'y' => 20], ['x' => 50, 'y' => 80]],
        ];
    }
}
