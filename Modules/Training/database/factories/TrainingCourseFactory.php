<?php

namespace Modules\Training\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Training\Models\TrainingCourse;

class TrainingCourseFactory extends Factory
{
    protected $model = TrainingCourse::class;

    public function definition(): array
    {
        return [
            'tenant_id' => $this->faker->uuid(),
            'title' => $this->faker->sentence(3),
            'mandatory' => false,
        ];
    }

    public function mandatory(): self
    {
        return $this->state(fn () => ['mandatory' => true]);
    }
}
