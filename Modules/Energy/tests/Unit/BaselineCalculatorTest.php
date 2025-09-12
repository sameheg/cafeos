<?php

namespace Modules\Energy\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Energy\Models\EnergyLog;
use Modules\Energy\Services\BaselineCalculator;
use Tests\TestCase;

class BaselineCalculatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_average_of_last_logs(): void
    {
        EnergyLog::create(['tenant_id' => 't1', 'kwh' => 10, 'logged_at' => now()->subMinutes(2)]);
        EnergyLog::create(['tenant_id' => 't1', 'kwh' => 20, 'logged_at' => now()->subMinute()]);

        $calc = new BaselineCalculator();

        $this->assertEquals(15, $calc->forTenant('t1'));
    }

    public function test_returns_null_when_no_logs(): void
    {
        $calc = new BaselineCalculator();
        $this->assertNull($calc->forTenant('t1'));
    }
}
