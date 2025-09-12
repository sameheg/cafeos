<?php

namespace Modules\EventManagement\Services;

class NpsCalculator
{
    public function score(array $ratings): float
    {
        if (count($ratings) === 0) {
            return 0.0;
        }

        return array_sum($ratings) / count($ratings);
    }
}
