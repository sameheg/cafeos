<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Event;
use Modules\Core\Events\JsonDomainEvent;
use Modules\Core\Models\EventLog;
use Modules\Core\Models\Tenant;
use Modules\Core\Support\EventBus;
use Tests\TestCase;

class EventDispatchTest extends TestCase
{
    public function test_event_is_logged_and_idempotent(): void
    {
        $tenant = Tenant::create(['name' => 'Acme', 'subdomain' => 'acme']);
        app()->instance('tenant', $tenant);

        Event::fake([JsonDomainEvent::class]);

        EventBus::emit('core.test', ['tenant_id' => $tenant->id], 'event-1');
        EventBus::emit('core.test', ['tenant_id' => $tenant->id], 'event-1');

        $this->assertEquals(1, EventLog::where('event_id', 'event-1')->count());

        Event::assertDispatched(JsonDomainEvent::class, function ($event) {
            return $event->event === 'core.test';
        });
    }
}
