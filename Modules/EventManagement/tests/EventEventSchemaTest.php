<?php

namespace Modules\EventManagement\Tests;

use Modules\EventManagement\Events\TicketSold;
use Tests\TestCase;

class EventEventSchemaTest extends TestCase
{
    public function test_schema(): void
    {
        $event = new TicketSold('t1', 'e1');
        $this->assertEquals(['ticket_id' => 't1', 'event_id' => 'e1'], $event->payload());
    }
}
