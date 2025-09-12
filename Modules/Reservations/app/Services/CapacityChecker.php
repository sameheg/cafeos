<?php

namespace Modules\Reservations\Services;

use DateTimeInterface;
use Modules\Reservations\Models\Reservation;
use Modules\Reservations\Models\ReservationSlot;
use Modules\Reservations\Models\ReservationStatus;

class CapacityChecker
{
    public function ensureCapacity(string $tenantId, DateTimeInterface $time): void
    {
        $date = $time->format('Y-m-d');
        $slot = ReservationSlot::where('tenant_id', $tenantId)->where('date', $date)->first();
        if (! $slot) {
            return; // treat as unlimited when slot not defined
        }
        $count = Reservation::where('tenant_id', $tenantId)
            ->whereDate('time', $date)
            ->whereIn('status', [ReservationStatus::Reserved, ReservationStatus::CheckedIn])
            ->count();
        if ($count >= $slot->capacity) {
            throw new OverbookException();
        }
    }
}

class OverbookException extends \RuntimeException
{
}
