<?php

namespace Modules\Jobs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Jobs\Models\JobApplication;
use Modules\Jobs\Models\JobPosting;

class JobApplicationFactory extends Factory
{
    protected $model = JobApplication::class;

    public function definition(): array
    {
        return [
            'tenant_id' => (string) Str::uuid(),
            'posting_id' => JobPosting::factory(),
            'cv_path' => 'cvs/'.Str::uuid().'.pdf',
            'status' => JobApplication::STATUS_APPLIED,
        ];
    }
}
