<?php

namespace Modules\FloorPlanDesigner\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class HandleReservationBooked implements ShouldQueue
{
    public int $tries = 3;
    public int $backoff = 10; // seconds

    public function handle(object $event): void
    {
        // idempotency could be enforced via table keyed by table_id
        Log::info('reservation.booked@v1 consumed', ['event' => $event]);
    }
}
