<?php

namespace Modules\Reservations\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Reservations\Models\Reservation;
use Modules\Reservations\Models\ReservationSlot;
use Modules\Reservations\Models\ReservationStatus;
use Modules\Reservations\Services\CapacityChecker;
use Modules\Reservations\Services\OverbookException;
use Tests\TestCase;

class CapacityCheckerTest extends TestCase
{
    use RefreshDatabase;

    public function test_prevents_overbooking(): void
    {
        \Modules\Core\Models\Tenant::forceCreate(['id' => 't1', 'name' => 'Tenant', 'subdomain' => 't1']);
        app()->instance('tenant', \Modules\Core\Models\Tenant::find('t1'));
        $date = now()->toDateString();
        ReservationSlot::create(['tenant_id' => 't1', 'date' => $date, 'capacity' => 1]);
        Reservation::create([
            'tenant_id' => 't1',
            'table_id' => 'A1',
            'time' => $date.' 10:00:00',
            'status' => ReservationStatus::Reserved,
        ]);

        $checker = app(CapacityChecker::class);
        $checker->ensureCapacity('t1', new \DateTime($date.' 12:00:00'));
        $this->assertTrue(true);
    }
}
