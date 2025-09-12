<?php

namespace Modules\Pos\Services;

use Modules\Pos\Models\PosTable;

class ReservationGuard
{
    public static function ensureStartAllowed(PosTable $table): void
    {
        // TODO: call Reservations module to confirm not reserved / or match reservation
    }
}
