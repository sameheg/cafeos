<?php

namespace Modules\Pos\Services;

use Modules\Pos\Models\Order;
use Modules\Billing\Events\UnpaidBillAlert;

class BillingService
{
    /**
     * Split an order total into a number of equal parts.
     */
    public function splitBill(Order $order, int $parts): array
    {
        if ($parts <= 0) {
            return [(float) $order->total];
        }

        $amount = (float) $order->total / $parts;
        return array_fill(0, $parts, $amount);
    }

    /**
     * Mark the given order as debt without persisting.
     */
    public function markAsDebt(Order $order): Order
    {
        $order->is_debt = true;
        event(new UnpaidBillAlert($order));
        return $order;
    }
}
