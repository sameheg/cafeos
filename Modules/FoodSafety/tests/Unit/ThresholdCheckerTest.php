<?php

namespace Modules\FoodSafety\Tests\Unit;

use Modules\FoodSafety\Services\ThresholdChecker;
use Tests\TestCase;

class ThresholdCheckerTest extends TestCase
{
    public function test_detects_breach(): void
    {
        $checker = new ThresholdChecker(['min' => 0, 'max' => 5]);
        $this->assertTrue($checker->isBreach(10));
        $this->assertFalse($checker->isBreach(3));
    }
}
