<?php

namespace Modules\Pos\Observers;

use Modules\Pos\Events\OrderPaid;
use Modules\Pos\Models\PosOrder;

class PosOrderObserver
{
    public function updated(PosOrder $order): void
    {
        if ($order->wasChanged('status') && $order->status === PosOrder::STATUS_PAID) {
            OrderPaid::dispatch($order);
        }
    }
}
