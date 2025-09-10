<?php

namespace Modules\Marketplace\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Marketplace\Models\Order;

class OrderPolicy extends BasePolicy
{
    protected static string $model = Order::class;
}
