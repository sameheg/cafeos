<?php

namespace App\Events\Reservation;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $reservation) {}
}
