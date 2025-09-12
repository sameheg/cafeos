<?php

namespace Tests\Unit;

use Modules\Reports\Services\AggregateCalculator;
use Tests\TestCase;

class AggregateCalculatorTest extends TestCase
{
    public function test_sum(): void
    {
        $calc = new AggregateCalculator();
        $this->assertEquals(6, $calc->sum([1,2,3]));
    }
}
