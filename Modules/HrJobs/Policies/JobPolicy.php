<?php

namespace Modules\HrJobs\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\HrJobs\Models\Job;

class JobPolicy extends BasePolicy
{
    protected static string $model = Job::class;
}
