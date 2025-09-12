<?php

declare(strict_types=1);

namespace Tests\Unit;

use Carbon\Carbon;
use Modules\Crm\Services\RfmCalculator;
use Tests\TestCase;

class RfmCalculatorTest extends TestCase
{
    public function test_calculates_rfm_score(): void
    {
        $calc = new RfmCalculator();
        $score = $calc->score(Carbon::now()->subDays(10), 15, 2000);
        $this->assertSame(5, $score);
    }
}
