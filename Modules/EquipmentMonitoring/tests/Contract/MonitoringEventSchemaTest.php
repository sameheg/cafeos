<?php

namespace Modules\EquipmentMonitoring\Tests\Contract;

use Modules\EquipmentMonitoring\Events\MonitoringAlertRaised;
use Tests\TestCase;

class MonitoringEventSchemaTest extends TestCase
{
    public function test_event_schema(): void
    {
        $event = new MonitoringAlertRaised('e1', 'pressure', 1.0, 't1');
        $payload = $event->toArray();
        $this->assertSame(['equipment_id', 'metric', 'value', 'tenant_id'], array_keys($payload));
    }
}
