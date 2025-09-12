<?php

namespace Modules\EventManagement\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SeatAssignedListener implements ShouldQueue
{
    public int $tries = 2;

    public function backoff(): array
    {
        return [1, 2];
    }

    public function handle(array $payload): void
    {
        Log::info('Seat assigned', $payload);
    }
}
