<?php

namespace Modules\Reports\Services;

class MetricCalculator
{
    /**
     * Calculate total sales from an array of amounts.
     *
     * @param  array<int, int|float>  $sales
     */
    public function salesTotal(array $sales): float
    {
        return array_sum($sales);
    }
}
