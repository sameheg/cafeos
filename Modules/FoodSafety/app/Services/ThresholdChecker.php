<?php

namespace Modules\FoodSafety\Services;

class ThresholdChecker
{
    public function __construct(private array $threshold)
    {
    }

    public function isBreach(float $temp): bool
    {
        return $temp < $this->threshold['min'] || $temp > $this->threshold['max'];
    }
}
