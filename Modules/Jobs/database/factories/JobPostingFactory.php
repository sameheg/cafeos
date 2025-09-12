<?php

namespace Modules\Jobs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Jobs\Models\JobPosting;

class JobPostingFactory extends Factory
{
    protected $model = JobPosting::class;

    public function definition(): array
    {
        return [
            'tenant_id' => (string) Str::uuid(),
            'title' => $this->faker->jobTitle(),
            'status' => JobPosting::STATUS_OPEN,
        ];
    }
}
