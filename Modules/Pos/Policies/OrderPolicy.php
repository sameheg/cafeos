<?php

namespace Modules\Pos\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Pos\Models\Order;

class OrderPolicy extends BasePolicy
{
    protected static string $model = Order::class;
}
