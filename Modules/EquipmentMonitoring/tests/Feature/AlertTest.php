<?php

namespace Modules\EquipmentMonitoring\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\EquipmentMonitoring\Events\MonitoringAlertRaised;
use Modules\EquipmentMonitoring\Models\MonitoringThreshold;
use Tests\TestCase;

class AlertTest extends TestCase
{
    use RefreshDatabase;

    public function test_alert_emitted_on_breach(): void
    {
        MonitoringThreshold::create([
            'tenant_id' => '00000000-0000-0000-0000-000000000001',
            'metric' => 'pressure',
            'min' => 10,
            'max' => 20,
        ]);

        Event::fake();

        $response = $this->postJson('/api/v1/monitoring/data', [
            'tenant_id' => '00000000-0000-0000-0000-000000000001',
            'equipment_id' => 'e1',
            'metric' => 'pressure',
            'value' => 25,
        ]);

        $response->assertJson(['received' => true]);

        Event::assertDispatched(MonitoringAlertRaised::class);
    }
}
