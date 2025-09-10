<?php

namespace Modules\TableReservations\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\TableReservations\Models\Reservation;

class ReservationPolicy extends BasePolicy
{
    protected static string $model = Reservation::class;
}
