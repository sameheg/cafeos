<?php

namespace Modules\EquipmentMaintenance\Tests\Unit;

use Modules\EquipmentMaintenance\Listeners\CreateTicketFromAlert;
use Tests\TestCase;

class PriorityQueueTest extends TestCase
{
    public function test_listener_uses_high_queue(): void
    {
        $listener = new CreateTicketFromAlert();
        $this->assertSame('high', $listener->queue);
    }
}
