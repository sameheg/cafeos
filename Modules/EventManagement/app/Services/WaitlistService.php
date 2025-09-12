<?php

namespace Modules\EventManagement\Services;

use Illuminate\Support\Facades\Cache;

class WaitlistService
{
    protected function key(string $eventId): string
    {
        return "event_waitlist_{$eventId}";
    }

    public function add(string $eventId, string $attendeeId): void
    {
        $waitlist = Cache::get($this->key($eventId), []);
        $waitlist[] = $attendeeId;
        Cache::put($this->key($eventId), $waitlist, 3600);
    }

    public function get(string $eventId): array
    {
        return Cache::get($this->key($eventId), []);
    }
}
