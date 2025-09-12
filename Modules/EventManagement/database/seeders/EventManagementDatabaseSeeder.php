<?php

namespace Modules\EventManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\EventManagement\Enums\TicketStatus;
use Modules\EventManagement\Models\Event;
use Modules\EventManagement\Models\EventTicket;

class EventManagementDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::create([
            'id' => Str::ulid(),
            'tenant_id' => (string) Str::uuid(),
            'name' => 'Sample Workshop',
            'capacity' => 1,
        ]);

        EventTicket::create([
            'id' => Str::ulid(),
            'tenant_id' => $event->tenant_id,
            'event_id' => $event->id,
            'attendee_id' => encrypt('seed-attendee'),
            'status' => TicketStatus::REFUNDED,
        ]);
    }
}
