<?php

namespace Modules\Reports\Policies;

use App\Models\User;
use Modules\Reports\Models\Report;

class ReportPolicy
{
    public function view(User $user, Report $report): bool
    {
        return $user->can('generate_report');
    }
}
