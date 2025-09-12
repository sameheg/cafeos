<?php

namespace Modules\Reservations\Observers;

use Modules\Core\Support\EventBus;
use Modules\Reservations\Models\Reservation;
use Modules\Reservations\Services\CapacityChecker;

class ReservationObserver
{
    public function created(Reservation $reservation): void
    {
        EventBus::emit('reservations.booked@v1', [
            'res_id' => $reservation->id,
            'table_id' => $reservation->table_id,
            'tenant_id' => $reservation->tenant_id,
        ]);
    }
}
