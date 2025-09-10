<?php

namespace Modules\Billing\Policies;

use Modules\Billing\Models\Subscription;
use Modules\Core\Policies\BasePolicy;

class SubscriptionPolicy extends BasePolicy
{
    protected static string $model = Subscription::class;
}
