<?php

namespace Modules\HRJobs\Tests\Unit;

use Modules\HRJobs\Events\ShiftCompleted;
use Modules\HRJobs\Models\Shift;
use Tests\TestCase;

class HrEventSchemaTest extends TestCase
{
    /** @test */
    public function shift_completed_event_matches_schema(): void
    {
        $shift = new Shift(['employee_id' => 'emp1']);
        $shift->id = '808';

        $event = new ShiftCompleted($shift);

        $this->assertEquals(
            [
                'event' => 'hr.shift.completed@v1',
                'data' => ['shift_id' => '808', 'employee_id' => 'emp1'],
            ],
            $event->toDomain()
        );
    }
}

