<?php

namespace Modules\Training\Services;

use Modules\Training\Events\CourseCompleted;
use Modules\Training\Models\TrainingProgress;

class ProgressTracker
{
    public function update(string $tenantId, string $employeeId, string $courseId, int $percent): TrainingProgress
    {
        $progress = TrainingProgress::firstOrCreate([
            'tenant_id' => $tenantId,
            'employee_id' => $employeeId,
            'course_id' => $courseId,
        ]);

        $progress->percent = $percent;
        $progress->save();

        if ($progress->percent >= 100) {
            event(new CourseCompleted($courseId, $employeeId));
        }

        return $progress;
    }
}
