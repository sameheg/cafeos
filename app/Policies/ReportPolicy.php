<?php

namespace App\Policies;

use App\User;

class ReportPolicy
{
    /**
     * Determine whether the user can view report metrics.
     */
    public function view(User $user): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Store Manager']);
    }
}

