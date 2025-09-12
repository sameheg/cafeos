<?php

namespace Modules\Training\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseCompleted
{
    use Dispatchable, SerializesModels;

    public string $courseId;
    public string $employeeId;
    public string $version = 'v1';

    public function __construct(string $courseId, string $employeeId)
    {
        $this->courseId = $courseId;
        $this->employeeId = $employeeId;
    }

    public function payload(): array
    {
        return [
            'course_id' => $this->courseId,
            'employee_id' => $this->employeeId,
        ];
    }
}
