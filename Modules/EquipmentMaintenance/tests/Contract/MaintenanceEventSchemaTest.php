<?php

namespace Modules\EquipmentMaintenance\Tests\Contract;

use Modules\EquipmentMaintenance\Events\TicketCreated;
use PHPUnit\Framework\TestCase;

class MaintenanceEventSchemaTest extends TestCase
{
    public function test_ticket_created_schema(): void
    {
        $event = new TicketCreated('t123', 'eq1');
        $this->assertSame([
            'ticket_id' => 't123',
            'equipment_id' => 'eq1',
        ], $event->toPayload());
    }
}
