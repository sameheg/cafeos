<?php

namespace Modules\EquipmentMaintenance\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\EquipmentMaintenance\Models\MaintenanceSchedule;
use Tests\TestCase;

class ScheduleJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_schedule_with_future_date(): void
    {
        $schedule = MaintenanceSchedule::create([
            'tenant_id' => 't1',
            'equipment_id' => 'eq1',
            'next_date' => now()->addDay()->toDateString(),
        ]);

        $this->assertDatabaseHas('maintenance_schedules', [
            'id' => $schedule->id,
        ]);
    }
}
