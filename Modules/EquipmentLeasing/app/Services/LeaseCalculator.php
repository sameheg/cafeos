<?php

namespace Modules\EquipmentLeasing\Services;

class LeaseCalculator
{
    public function monthly(float $price, int $months): float
    {
        return round($price / max($months, 1), 2);
    }
}

