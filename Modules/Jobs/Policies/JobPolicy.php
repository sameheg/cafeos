<?php

namespace Modules\Jobs\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Jobs\Models\Job;

class JobPolicy extends BasePolicy
{
    protected static string $model = Job::class;
}
