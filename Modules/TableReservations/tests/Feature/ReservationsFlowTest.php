<?php

namespace Modules\TableReservations\Tests\Feature;

use App\Http\Middleware\SetUserLocale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Modules\Notifications\Services\NotificationService;
use Modules\TableReservations\Models\Reservation;
use Modules\TableReservations\Models\Table;
use Tests\TestCase;

class ReservationsFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_confirmation_sends_notifications(): void
    {
        $this->withoutMiddleware([SetUserLocale::class]);

        $user = User::factory()->create(['tenant_id' => 1]);
        $table = Table::create(['name' => 'A1', 'seats' => 4, 'status' => 'available']);
        $reservation = Reservation::create([
            'table_id' => $table->id,
            'customer_name' => 'John Doe',
            'phone' => '1234567890',
            'reservation_time' => now(),
            'status' => 'pending',
        ]);

        $this->app->alias('db', 'database');
        $mock = Mockery::mock(NotificationService::class);
        $mock->shouldReceive('send')->once();
        $this->app->instance(NotificationService::class, $mock);

        $response = $this->actingAs($user)->postJson('/api/v1/reservations/'.$reservation->id.'/confirm');

        $response->assertOk();
        $this->assertDatabaseHas('reservations', ['id' => $reservation->id, 'status' => 'confirmed']);
    }
}
