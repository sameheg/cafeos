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
     * Mark the given order as debt and persist the change.
     *
     * If the order is already marked as debt, no action is taken.
     */
    public function markAsDebt(Order $order): Order
    {
        if ($order->is_debt) {
            return $order;
        }

        $order->is_debt = true;
        $order->save();

        event(new UnpaidBillAlert($order));

        return $order;
    }
}
