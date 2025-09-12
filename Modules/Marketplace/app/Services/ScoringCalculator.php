<?php

namespace Modules\Marketplace\Services;

class ScoringCalculator
{
    public function score(float $price, float $history = 0): float
    {
        return max(0, 100 - $price + $history);
    }
}
