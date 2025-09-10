<?php

namespace Modules\Pos\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Pos\Models\Order;

class OrderCacheInvalidated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Order $order)
    {
    }
}
