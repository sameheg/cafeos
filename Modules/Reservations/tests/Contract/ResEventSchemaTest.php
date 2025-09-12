<?php

namespace Modules\Reservations\Tests\Contract;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\EventLog;
use Modules\Reservations\Models\ReservationSlot;
use Tests\TestCase;

class ResEventSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_schema_contains_required_fields(): void
    {
        \Modules\Core\Models\Tenant::forceCreate(['id' => 't1', 'name' => 'Tenant', 'subdomain' => 't1']);
        app()->instance('tenant', \Modules\Core\Models\Tenant::find('t1'));
        $date = now()->addDay();
        ReservationSlot::create(['tenant_id' => 't1', 'date' => $date->toDateString(), 'capacity' => 1]);

        $this->postJson('/api/v1/reservations', [
            'tenant_id' => 't1',
            'time' => $date->copy()->setTime(10, 0)->toDateTimeString(),
            'table_id' => 'A1',
        ]);

        $event = EventLog::first();
        $this->assertEquals('reservations.booked@v1', $event->event_name);
        $this->assertArrayHasKey('res_id', $event->data);
        $this->assertArrayHasKey('table_id', $event->data);
    }
}
