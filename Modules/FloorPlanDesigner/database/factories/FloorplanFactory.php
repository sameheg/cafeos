<?php

namespace Modules\FloorPlanDesigner\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\FloorPlanDesigner\Models\Floorplan;

class FloorplanFactory extends Factory
{
    protected $model = Floorplan::class;

    public function definition(): array
    {
        return [
            'tenant_id' => $this->faker->uuid(),
            'json_data' => ['tables' => [1, 2, 3]],
            'version' => 1,
            'state' => 'draft',
        ];
    }
}
