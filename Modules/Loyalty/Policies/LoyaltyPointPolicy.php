<?php

namespace Modules\Loyalty\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Loyalty\Models\LoyaltyPoint;

class LoyaltyPointPolicy extends BasePolicy
{
    protected static string $model = LoyaltyPoint::class;
}
