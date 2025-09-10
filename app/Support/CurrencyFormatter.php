<?php

namespace App\Support;

use NumberFormatter;

class CurrencyFormatter
{
    public static function format(float $amount): string
    {
        $currency = config('app.currency', 'USD');

        $tenantGetter = null;
        if (function_exists(__NAMESPACE__ . '\\tenant')) {
            $tenantGetter = __NAMESPACE__ . '\\tenant';
        } elseif (function_exists('tenant')) {
            $tenantGetter = 'tenant';
        }

        if ($tenantGetter) {
            $tenantCurrency = $tenantGetter('currency');
            if ($tenantCurrency) {
                $currency = $tenantCurrency;
            }
        }

        $locale = app()->getLocale();
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        return $formatter->formatCurrency($amount, $currency);
    }
}
