<?php

namespace Modules\Training\Services;

use Modules\Training\Models\TrainingCourse;
use Modules\Training\Models\TrainingProgress;

class MandatoryChecker
{
    public function compliant(string $tenantId, string $employeeId): bool
    {
        $mandatory = TrainingCourse::query()
            ->where('tenant_id', $tenantId)
            ->where('mandatory', true)
            ->pluck('id');

        if ($mandatory->isEmpty()) {
            return true;
        }

        $completed = TrainingProgress::query()
            ->where('tenant_id', $tenantId)
            ->where('employee_id', $employeeId)
            ->whereIn('course_id', $mandatory)
            ->where('percent', 100)
            ->count();

        return $completed === $mandatory->count();
    }
}
