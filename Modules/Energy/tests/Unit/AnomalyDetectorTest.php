<?php

namespace Modules\Energy\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Energy\Models\EnergyLog;
use Modules\Energy\Services\AnomalyDetector;
use Modules\Energy\Services\BaselineCalculator;
use Tests\TestCase;

class AnomalyDetectorTest extends TestCase
{
    use RefreshDatabase;

    public function test_detects_anomaly_when_exceeds_baseline(): void
    {
        EnergyLog::create(['tenant_id' => 't1', 'kwh' => 5, 'logged_at' => now()->subMinute()]);
        EnergyLog::create(['tenant_id' => 't1', 'kwh' => 5, 'logged_at' => now()]);

        $log = EnergyLog::create(['tenant_id' => 't1', 'kwh' => 15, 'logged_at' => now()->addMinute()]);

        $detector = new AnomalyDetector(new BaselineCalculator());
        $this->assertTrue($detector->check($log));
        $this->assertTrue($log->refresh()->is_anomaly);
    }

    public function test_returns_false_when_within_baseline(): void
    {
        EnergyLog::create(['tenant_id' => 't1', 'kwh' => 5, 'logged_at' => now()]);

        $log = EnergyLog::create(['tenant_id' => 't1', 'kwh' => 5, 'logged_at' => now()->addMinute()]);

        $detector = new AnomalyDetector(new BaselineCalculator());
        $this->assertFalse($detector->check($log));
    }
}
