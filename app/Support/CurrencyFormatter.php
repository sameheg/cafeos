<?php

namespace App\Support;

use NumberFormatter;

class CurrencyFormatter
{
    public static function format(float $amount): string
    {
        $currency = config('app.currency', 'USD');
        $locale = app()->getLocale();
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currency);
    }
}
