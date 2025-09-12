<?php

namespace Modules\EventManagement\Services;

use Illuminate\Support\Facades\Cache;
use Modules\EventManagement\Models\Event;

class CapacityChecker
{
    public function hasCapacity(Event $event): bool
    {
        $sold = $event->tickets()->where('status', 'sold')->count();
        Cache::put("event_{$event->id}_sold", $sold, 60);

        return $sold < $event->capacity;
    }
}
