<?php

namespace Modules\Kiosk\Services;

use Modules\Kiosk\Models\Kiosk;

class QueueLimiter
{
    public function tooMany(Kiosk $kiosk): bool
    {
        return $kiosk->orders()->where('status', 'queued')->count() >= $kiosk->max_queue;
    }
}
