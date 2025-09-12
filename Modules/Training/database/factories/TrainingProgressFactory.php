<?php

namespace Modules\Training\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Training\Models\TrainingCourse;
use Modules\Training\Models\TrainingProgress;

class TrainingProgressFactory extends Factory
{
    protected $model = TrainingProgress::class;

    public function definition(): array
    {
        return [
            'tenant_id' => $this->faker->uuid(),
            'employee_id' => $this->faker->uuid(),
            'course_id' => TrainingCourse::factory(),
            'percent' => 0,
        ];
    }
}
