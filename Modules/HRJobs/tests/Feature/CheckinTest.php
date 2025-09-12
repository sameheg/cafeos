<?php

namespace Modules\HRJobs\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Modules\HRJobs\Events\ShiftCompleted;
use Modules\HRJobs\Models\Employee;
use Modules\HRJobs\Models\Shift;
use Tests\TestCase;

class CheckinTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function employee_checkin_marks_shift_attended_and_creates_payroll(): void
    {
        $employee = Employee::create([
            'tenant_id' => (string) Str::uuid(),
            'name' => 'Cara',
            'role' => 'staff',
        ]);

        $shift = Shift::create([
            'tenant_id' => $employee->tenant_id,
            'employee_id' => $employee->id,
            'start' => now(),
            'end' => now()->addHours(8),
            'status' => Shift::STATUS_SCHEDULED,
        ]);

        Event::fake();

        $response = $this->postJson('/v1/hr/shifts/'.$shift->id.'/checkin');

        $response->assertOk();
        Event::assertDispatched(ShiftCompleted::class);
        $this->assertDatabaseHas('hr_shifts', ['id' => $shift->id, 'status' => Shift::STATUS_PAID]);
        $this->assertDatabaseHas('hr_payrolls', ['employee_id' => $employee->id]);
    }
}

