<?php

namespace Modules\Billing\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Billing\Models\Plan;

class PlanPolicy extends BasePolicy
{
    protected static string $model = Plan::class;
}
