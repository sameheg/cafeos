<?php

namespace App\Listeners;

use App\Events\AttendanceRecorded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendAttendanceToPayroll implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(AttendanceRecorded $event): void
    {
        $attendance = $event->attendance;

        if ($attendance->clock_in && $attendance->clock_out) {
            $hours = $attendance->hours_worked;
            Log::info("Payroll integration: attendance {$attendance->id} worked {$hours} hours.");
        }
    }
}
