<?php

namespace Modules\Billing\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Pos\Models\Order;

class UnpaidBillAlert
{
    use Dispatchable;

    public function __construct(public Order $order)
    {
    }
}
