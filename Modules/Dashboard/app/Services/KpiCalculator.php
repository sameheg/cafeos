<?php

namespace Modules\Dashboard\Services;

class KpiCalculator
{
    public function calculate(string $window): array
    {
        // Placeholder implementation. Real logic would query materialized views.
        return [
            'sales' => 1000,
            'orders' => 50,
        ];
    }
}
