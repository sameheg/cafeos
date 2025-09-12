<?php

namespace Modules\Training\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Training\Models\TrainingCourse;
use Modules\Training\Models\TrainingProgress;

class TrainingDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = fake()->uuid();

        $orientation = TrainingCourse::create([
            'tenant_id' => $tenant,
            'title' => 'Orientation',
            'mandatory' => true,
        ]);

        $optional = TrainingCourse::create([
            'tenant_id' => $tenant,
            'title' => 'Optional Safety',
            'mandatory' => false,
        ]);

        TrainingProgress::create([
            'tenant_id' => $tenant,
            'employee_id' => 'emp_drop',
            'course_id' => $orientation->id,
            'percent' => 50,
        ]);

        TrainingProgress::create([
            'tenant_id' => $tenant,
            'employee_id' => 'emp_full',
            'course_id' => $optional->id,
            'percent' => 100,
        ]);
    }
}
