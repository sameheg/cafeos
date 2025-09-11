<?php

namespace Modules\Inventory\Services;

class UnitConversionService
{
    protected array $map = [
        'g' => ['kg' => 0.001],
        'kg' => ['g' => 1000],
    ];

    public function convert(float $value, string $from, string $to): float
    {
        if ($from === $to) {
            return $value;
        }
        return $value * ($this->map[$from][$to] ?? 1);
    }
}
