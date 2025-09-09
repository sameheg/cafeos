<?php

namespace Modules\Pos\Services;

use Modules\Core\Contracts\OrderServiceInterface;
use Modules\Pos\Models\Order;

class OrderService implements OrderServiceInterface
{
    public function make(array $attributes = []): Order
    {
        return new Order($attributes);
    }
}
