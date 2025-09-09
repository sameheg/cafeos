<?php

namespace Modules\Core\Contracts;

use Modules\Pos\Models\Order;

interface OrderServiceInterface
{
    public function make(array $attributes = []): Order;
}
