<?php
namespace Modules\Reservations\App\Policies;

use App\Models\User;
use Modules\Reservations\App\Models\Reservation;

class ReservationPolicy
{
    public function view(User $user, Reservation $reservation): bool
    {
        return $user->hasRole(['Owner','Manager','Staff']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['Owner','Manager']);
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return $user->hasRole(['Owner','Manager']);
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->hasRole(['Owner','Manager']);
    }
}
