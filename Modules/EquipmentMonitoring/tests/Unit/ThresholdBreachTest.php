<?php

namespace Modules\EquipmentMonitoring\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\EquipmentMonitoring\Events\MonitoringAlertRaised;
use Modules\EquipmentMonitoring\Models\MonitoringData;
use Modules\EquipmentMonitoring\Models\MonitoringThreshold;
use Modules\EquipmentMonitoring\Services\ThresholdEvaluator;
use Tests\TestCase;

class ThresholdBreachTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_detects_threshold_breach(): void
    {
        MonitoringThreshold::create([
            'tenant_id' => 't1',
            'metric' => 'pressure',
            'min' => 10,
            'max' => 20,
        ]);

        Event::fake();

        $data = MonitoringData::create([
            'tenant_id' => 't1',
            'equipment_id' => 'e1',
            'metric' => 'pressure',
            'value' => 30,
            'timestamp' => now(),
        ]);

        $evaluator = new ThresholdEvaluator();
        $this->assertTrue($evaluator->isBreached($data));

        event(new MonitoringAlertRaised($data->equipment_id, $data->metric, $data->value, $data->tenant_id));
        Event::assertDispatched(MonitoringAlertRaised::class);
    }
}
