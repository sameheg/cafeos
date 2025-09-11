<?php

namespace Modules\Core\Support;

use Illuminate\Support\Str;
use Modules\Core\Models\EventLog;

class EventBus
{
    public static function emit(string $eventName, array $data, ?string $eventId = null): void
    {
        $eventId = $eventId ?: (string) Str::ulid();

        if (EventLog::where('event_id', $eventId)->exists()) {
            return; // idempotent
        }

        EventLog::create([
            'tenant_id' => $data['tenant_id'] ?? null,
            'event_name' => $eventName,
            'data' => $data,
            'processed' => false,
            'event_id' => $eventId,
        ]);

        event(new \Modules\Core\Events\JsonDomainEvent($eventName, $data, $eventId));
    }
}
