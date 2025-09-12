<?php

namespace Modules\Reservations\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Reservations\Models\Reservation;
use Modules\Reservations\Models\ReservationStatus;

class ReleaseNoShowReservations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        Reservation::where('status', ReservationStatus::Reserved)
            ->where('time', '<', now()->subMinutes(15))
            ->update(['status' => ReservationStatus::NoShow]);
    }
}
