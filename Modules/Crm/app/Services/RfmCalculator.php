<?php

declare(strict_types=1);

namespace Modules\Crm\Services;

use Carbon\CarbonInterface;

class RfmCalculator
{
    /**
     * Calculate a simple RFM score (1-5) based on recency, frequency, and monetary value.
     */
    public function score(CarbonInterface $lastPurchase, int $frequency, float $monetary): int
    {
        $recencyScore = $lastPurchase->diffInDays(now()) < 30 ? 5 : 1;
        $frequencyScore = $frequency > 10 ? 5 : 1;
        $monetaryScore = $monetary > 1000 ? 5 : 1;

        $avg = intdiv($recencyScore + $frequencyScore + $monetaryScore, 3);
        return max(1, min(5, $avg));
    }
}
