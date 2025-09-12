<?php

namespace Modules\Reservations\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Reservations\Jobs\ReleaseNoShowReservations;
use Modules\Reservations\Models\Reservation;
use Modules\Reservations\Models\ReservationSlot;
use Modules\Reservations\Models\ReservationStatus;
use Tests\TestCase;

class ReleaseTimerTest extends TestCase
{
    use RefreshDatabase;

    public function test_marks_no_show_after_timeout(): void
    {
        \Modules\Core\Models\Tenant::forceCreate(['id' => 't1', 'name' => 'Tenant', 'subdomain' => 't1']);
        app()->instance('tenant', \Modules\Core\Models\Tenant::find('t1'));
        $date = now();
        ReservationSlot::create(['tenant_id' => 't1', 'date' => $date->toDateString(), 'capacity' => 5]);

        $reservation = Reservation::withoutEvents(function () use ($date) {
            return Reservation::create([
                'tenant_id' => 't1',
                'table_id' => 'A1',
                'time' => $date->copy()->subMinutes(20),
                'status' => ReservationStatus::Reserved,
            ]);
        });

        (new ReleaseNoShowReservations())->handle();

        $this->assertEquals(ReservationStatus::NoShow, $reservation->fresh()->status);
    }
}
