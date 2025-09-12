<?php

namespace Modules\Dashboard\Tests\Unit;

use Modules\Dashboard\Services\KpiCalculator;
use PHPUnit\Framework\TestCase;

class KpiCalculatorTest extends TestCase
{
    public function test_calculates_basic_kpis(): void
    {
        $calc = new KpiCalculator();
        $data = $calc->calculate('1h');
        $this->assertArrayHasKey('sales', $data);
    }
}
