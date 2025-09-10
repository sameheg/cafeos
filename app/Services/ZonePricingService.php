<?php

namespace App\Services;

class ZonePricingService
{
    /**
     * Calculate the price between two zones.
     */
    public function calculatePrice(string $originZone, string $destinationZone): float
    {
        $matrix = config('zone_pricing.matrix');

        return $matrix[$originZone][$destinationZone] ?? 0.0;
    }
}
