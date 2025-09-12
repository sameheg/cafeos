<?php

namespace Modules\Dashboard\Tests\Contract;

use Modules\Dashboard\Events\DashboardAlertTriggered;
use Tests\TestCase;

class DashboardEventSchemaTest extends TestCase
{
    public function test_alert_event_payload(): void
    {
        $event = new DashboardAlertTriggered('sales', 1000);
        $this->assertEquals('sales', $event->broadcastWith()['kpi']);
        $this->assertEquals(1000, $event->broadcastWith()['value']);
    }
}
