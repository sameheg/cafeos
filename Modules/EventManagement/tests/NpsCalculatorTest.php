<?php

namespace Modules\EventManagement\Tests;

use Modules\EventManagement\Services\NpsCalculator;
use Tests\TestCase;

class NpsCalculatorTest extends TestCase
{
    public function test_score(): void
    {
        $calc = new NpsCalculator();
        $score = $calc->score([5, 4, 5]);
        $this->assertEqualsWithDelta(4.6666666667, $score, 0.0001);
    }
}
