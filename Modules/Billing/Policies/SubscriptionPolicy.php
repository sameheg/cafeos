<?php

namespace Modules\Billing\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Billing\Models\Subscription;

class SubscriptionPolicy extends BasePolicy
{
    protected static string $model = Subscription::class;
}
