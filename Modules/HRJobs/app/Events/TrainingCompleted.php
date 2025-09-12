<?php

namespace Modules\HRJobs\Events;

class TrainingCompleted
{
    public function __construct(public string $employee_id)
    {
    }
}

