<?php

namespace Modules\Billing\Policies;

use Modules\Billing\Models\Plan;
use Modules\Core\Policies\BasePolicy;

class PlanPolicy extends BasePolicy
{
    protected static string $model = Plan::class;
}
