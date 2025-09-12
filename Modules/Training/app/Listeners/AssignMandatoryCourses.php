<?php

namespace Modules\Training\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Training\Events\HrOnboarded;
use Modules\Training\Models\TrainingCourse;
use Modules\Training\Models\TrainingProgress;

class AssignMandatoryCourses implements ShouldQueue
{
    public int $tries = 2;

    public function backoff(): array
    {
        return [1, 2];
    }

    public function handle(HrOnboarded $event): void
    {
        $courses = TrainingCourse::query()
            ->where('tenant_id', $event->tenantId)
            ->where('mandatory', true)
            ->get();

        foreach ($courses as $course) {
            TrainingProgress::firstOrCreate([
                'tenant_id' => $event->tenantId,
                'employee_id' => $event->employeeId,
                'course_id' => $course->id,
            ], [
                'percent' => 0,
            ]);
        }
    }
}
