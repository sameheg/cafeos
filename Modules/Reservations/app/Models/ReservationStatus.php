<?php

namespace Modules\Reservations\Models;

enum ReservationStatus: string
{
    case Reserved = 'reserved';
    case CheckedIn = 'checkedin';
    case NoShow = 'noshow';
}
