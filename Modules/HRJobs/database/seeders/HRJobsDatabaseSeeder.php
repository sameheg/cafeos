<?php

namespace Modules\HRJobs\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\HRJobs\Models\Employee;
use Modules\HRJobs\Models\Shift;

class HRJobsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = (string) \Str::uuid();

        $employee = Employee::create([
            'tenant_id' => $tenant,
            'name' => 'Alice',
            'role' => 'staff',
        ]);

        // Normal shift
        Shift::create([
            'tenant_id' => $tenant,
            'employee_id' => $employee->id,
            'start' => now()->subDay(),
            'end' => now()->subDay()->addHours(8),
            'status' => Shift::STATUS_ATTENDED,
        ]);

        // Absenteeism
        Shift::create([
            'tenant_id' => $tenant,
            'employee_id' => $employee->id,
            'start' => now()->addDay(),
            'end' => now()->addDay()->addHours(8),
            'status' => Shift::STATUS_ABSENT,
        ]);
        // Overtime
        Shift::create([
            'tenant_id' => $tenant,
            'employee_id' => $employee->id,
            'start' => now()->addDays(2),
            'end' => now()->addDays(2)->addHours(10),
            'status' => Shift::STATUS_ATTENDED,
        ]);
    }
}
