<?php

namespace Modules\EventManagement\Tests;

use Illuminate\Support\Str;
use Modules\EventManagement\Models\Event;
use Modules\EventManagement\Models\EventTicket;
use Modules\EventManagement\Services\CapacityChecker;
use Modules\EventManagement\Enums\TicketStatus;
use Tests\TestCase;

class CapacityCheckerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_has_capacity(): void
    {
        $event = Event::create([
            'id' => Str::ulid(),
            'tenant_id' => (string) Str::uuid(),
            'name' => 'Test Event',
            'capacity' => 1,
        ]);

        $checker = new CapacityChecker();
        $this->assertTrue($checker->hasCapacity($event));

        EventTicket::create([
            'id' => Str::ulid(),
            'tenant_id' => $event->tenant_id,
            'event_id' => $event->id,
            'attendee_id' => 'a',
            'status' => TicketStatus::SOLD,
        ]);

        $this->assertFalse($checker->hasCapacity($event));
    }
}
