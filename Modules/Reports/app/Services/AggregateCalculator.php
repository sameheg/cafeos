<?php

namespace Modules\Reports\Services;

class AggregateCalculator
{
    public function sum(array $values): float
    {
        return array_sum($values);
    }
}
