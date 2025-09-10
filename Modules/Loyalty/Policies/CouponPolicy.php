<?php

namespace Modules\Loyalty\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Loyalty\Models\Coupon;

class CouponPolicy extends BasePolicy
{
    protected static string $model = Coupon::class;
}
