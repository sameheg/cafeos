<?php

namespace Modules\Marketplace\Tests\Unit;

use Modules\Marketplace\Services\ScoringCalculator;
use PHPUnit\Framework\TestCase;

class ScoringCalculatorTest extends TestCase
{
    public function test_basic_score(): void
    {
        $calc = new ScoringCalculator();
        $this->assertSame(90.0, $calc->score(10));
    }
}
