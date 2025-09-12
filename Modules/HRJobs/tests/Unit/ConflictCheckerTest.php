<?php

namespace Modules\HRJobs\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Modules\HRJobs\Models\Employee;
use Modules\HRJobs\Models\Shift;
use Tests\TestCase;

class ConflictCheckerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_detects_shift_conflicts(): void
    {
        $employee = Employee::create([
            'tenant_id' => (string) Str::uuid(),
            'name' => 'Bob',
            'role' => 'staff',
        ]);

        Shift::create([
            'tenant_id' => $employee->tenant_id,
            'employee_id' => $employee->id,
            'start' => Carbon::parse('2024-01-01 09:00:00'),
            'end' => Carbon::parse('2024-01-01 17:00:00'),
            'status' => Shift::STATUS_SCHEDULED,
        ]);

        $conflict = Shift::conflicts(
            $employee->id,
            Carbon::parse('2024-01-01 16:00:00'),
            Carbon::parse('2024-01-01 18:00:00')
        )->exists();

        $this->assertTrue($conflict);
    }
}

