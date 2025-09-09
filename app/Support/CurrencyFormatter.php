<?php

namespace App\Support;

use NumberFormatter;

class CurrencyFormatter
{
    public static function format(float $amount): string
    {
        $currency = config('app.currency', 'USD');

        if (function_exists('tenant')) {
            $tenantCurrency = tenant('currency');
            if ($tenantCurrency) {
                $currency = $tenantCurrency;
            }
        }

        $locale = app()->getLocale();
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        return $formatter->formatCurrency($amount, $currency);
    }
}
