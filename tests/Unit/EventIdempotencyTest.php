<?php

namespace Tests\Unit;

use Modules\Core\Models\EventLog;
use Modules\Core\Support\EventBus;
use Tests\TestCase;

class EventIdempotencyTest extends TestCase
{
    public function test_events_are_idempotent(): void
    {
        EventBus::emit('core.test', ['tenant_id' => null], 'evt-1');
        EventBus::emit('core.test', ['tenant_id' => null], 'evt-1');

        $this->assertEquals(1, EventLog::where('event_id', 'evt-1')->count());
    }
}
