<?php

namespace Modules\Notifications\Tests\Contract;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Modules\Core\Events\JsonDomainEvent;
use Modules\Notifications\Models\NotificationTemplate;
use Modules\Notifications\Services\NotificationSender;
use Tests\TestCase;

class NotifEventSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_sent_event_schema(): void
    {
        Event::fake();
        app()->instance('tenant', (object) ['id' => 't1']);
        $template = NotificationTemplate::create([
            'tenant_id' => 't1',
            'name' => 'tmp',
            'content' => 'Hi',
        ]);

        $sender = new NotificationSender;
        $sender->sendToRecipient($template, 'user@example.com', 'mail', null, Str::ulid());

        Event::assertDispatched(JsonDomainEvent::class, function ($e) {
            return $e->event === 'notifications.sent@v1'
                && isset($e->data['notif_id'])
                && isset($e->data['channel']);
        });
    }
}
