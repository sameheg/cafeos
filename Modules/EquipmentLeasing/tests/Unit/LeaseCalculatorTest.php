<?php

namespace Modules\EquipmentLeasing\Tests\Unit;

use Modules\EquipmentLeasing\Services\LeaseCalculator;
use PHPUnit\Framework\TestCase;

class LeaseCalculatorTest extends TestCase
{
    public function test_monthly_payment_is_calculated(): void
    {
        $calculator = new LeaseCalculator();

        $this->assertSame(100.0, $calculator->monthly(1200, 12));
    }
}

