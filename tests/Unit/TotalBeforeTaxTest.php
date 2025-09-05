<?php

namespace Tests\Unit;

use App\Utils\ProductUtil;
use PHPUnit\Framework\TestCase;

class TotalBeforeTaxTest extends TestCase
{
    public function test_value_is_parsed_when_present()
    {
        $productUtil = new ProductUtil();
        $currency = (object)[
            'thousand_separator' => ',',
            'decimal_separator' => '.'
        ];
        $data = ['total_before_tax' => '123.45'];
        $exchangeRate = 1;

        $result = $productUtil->num_uf($data['total_before_tax'] ?? 0, $currency) * $exchangeRate;

        $this->assertEquals(123.45, $result);
    }

    public function test_default_to_zero_when_key_missing()
    {
        $productUtil = new ProductUtil();
        $currency = (object)[
            'thousand_separator' => ',',
            'decimal_separator' => '.'
        ];
        $data = [];
        $exchangeRate = 1;

        $result = $productUtil->num_uf($data['total_before_tax'] ?? 0, $currency) * $exchangeRate;

        $this->assertEquals(0, $result);
    }
}
