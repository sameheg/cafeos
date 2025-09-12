<?php
namespace Modules\Pos\App\Services;

use Modules\Pos\App\Models\Order;

class TotalsCalculator
{
    public function recalc(Order $order): void
    {
        $order->recalcTotals();
    }
}
