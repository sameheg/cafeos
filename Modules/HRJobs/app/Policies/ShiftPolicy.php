<?php

namespace Modules\HRJobs\Policies;

use Modules\HRJobs\Models\Employee;
use Modules\HRJobs\Models\Shift;

class ShiftPolicy
{
    public function schedule_shift(Employee $user): bool
    {
        return in_array($user->role, ['manager', 'owner']);
    }

    public function view(Employee $user, Shift $shift): bool
    {
        return $user->tenant_id === $shift->tenant_id;
    }
}

