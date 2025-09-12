<?php

namespace Modules\Reports\Tests\Unit;

use Modules\Reports\Services\MetricCalculator;
use Tests\TestCase;

class MetricCalculatorTest extends TestCase
{
    public function test_sales_total(): void
    {
        $calculator = new MetricCalculator;

        $this->assertSame(15.0, $calculator->salesTotal([5, 3, 7]));
    }
}
