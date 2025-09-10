<?php

namespace Modules\HrJobs\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\HrJobs\Models\Application;

class ApplicationPolicy extends BasePolicy
{
    protected static string $model = Application::class;
}
