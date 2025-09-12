<?php

namespace Modules\Billing\Services;

class InvoiceCalculator
{
    public function __construct(private bool $prorationEnabled = false)
    {
    }

    public function calculate(float $baseAmount, float $prorationRatio = 1.0): float
    {
        $amount = $baseAmount;
        if ($this->prorationEnabled) {
            $amount = $baseAmount * $prorationRatio;
        }

        return round($amount, 2);
    }
}
