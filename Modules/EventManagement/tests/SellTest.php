<?php

namespace Modules\EventManagement\Tests;

use Illuminate\Support\Str;
use Modules\EventManagement\Models\Event;
use Tests\TestCase;

class SellTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_sell_and_sold_out(): void
    {
        $event = Event::create([
            'id' => Str::ulid(),
            'tenant_id' => (string) Str::uuid(),
            'name' => 'Conference',
            'capacity' => 1,
        ]);

        $response = $this->postJson('/api/v1/events/tickets', ['event_id' => $event->id]);
        $response->assertStatus(200)->assertJsonStructure(['ticket_id']);

        $response = $this->postJson('/api/v1/events/tickets', ['event_id' => $event->id]);
        $response->assertStatus(410);
    }
}
