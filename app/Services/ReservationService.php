<?php

namespace App\Services;

use App\Events\Reservation\ReservationConfirmed;

class ReservationService
{
    public function confirm(array $data): array
    {
        ReservationConfirmed::dispatch($data);

        return $data;
    }
}
