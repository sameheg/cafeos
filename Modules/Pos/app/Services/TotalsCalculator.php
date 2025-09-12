<?php

namespace Modules\Pos\Services;

use Modules\Pos\Models\PosOrder;

class TotalsCalculator
{
    public static function recalc(PosOrder $order): PosOrder
    {
        $subtotal = $order->items()->sum(\DB::raw('qty * price'));
        $discount = $order->discounts()->sum(\DB::raw('amount')) + ($subtotal * ($order->discounts()->sum('percent')/100));
        $tax = (($subtotal - $discount) * ($order->tax_percent/100));
        $service = (($subtotal - $discount) * ($order->service_percent/100));
        $total = max(0, $subtotal - $discount + $tax + $service);
        $paid = $order->payments()->sum('amount');
        $outstanding = max(0, $total - $paid);
        $order->update([
            'subtotal'=>$subtotal,'discount_total'=>$discount,'tax_amount'=>$tax,'service_amount'=>$service,
            'total'=>$total,'paid_total'=>$paid,'outstanding_total'=>$outstanding
        ]);
        return $order->refresh();
    }
}
