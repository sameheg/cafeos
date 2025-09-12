<?php

namespace Modules\Energy\Tests\Contract;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Energy\Events\EnergyAnomalyDetected;
use Modules\Energy\Models\EnergyLog;
use Tests\TestCase;

class EnergyEventSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_schema_matches_expected_structure(): void
    {
        $log = EnergyLog::create([
            'tenant_id' => 't1',
            'kwh' => 10,
            'logged_at' => now(),
            'is_anomaly' => true,
        ]);

        $event = new EnergyAnomalyDetected($log);
        $payload = $event->toArray();

        $this->assertSame('energy.anomaly.detected', $payload['event']);
        $this->assertSame($log->id, $payload['data']['meter_id']);
        $this->assertSame(10.0, $payload['data']['kwh']);
    }
}
