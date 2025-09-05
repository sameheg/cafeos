<?php

namespace Modules\Compliance\Services;

use Illuminate\Support\Facades\DB;

class TaxEngine
{
    /**
     * Calculate tax based on rules for a given country.
     *
     * @param float $amount
     * @param string $countryCode
     * @return float
     */
    public function calculate(float $amount, string $countryCode): float
    {
        $rule = DB::table('tax_rules')
            ->where('country_code', $countryCode)
            ->first();

        $rate = $rule->rate ?? 0;

        return round($amount * ($rate / 100), 2);
    }
}
