<?php
namespace Modules\Reservations\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Reservations\App\Models\Reservation;

class ReservationCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_reservations()
    {
        Reservation::factory()->count(3)->create();
        $response = $this->getJson('/api/v1/reservations');
        $response->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_it_creates_a_reservation()
    {
        $data = [
            'tenant_id' => 1,
            'table_id' => 5,
            'status' => 'confirmed',
            'start_at' => now()->addHour()->toISOString(),
            'end_at' => now()->addHours(2)->toISOString(),
        ];
        $response = $this->postJson('/api/v1/reservations', $data);
        $response->assertStatus(201)->assertJsonFragment(['table_id' => 5]);
        $this->assertDatabaseHas('reservations', ['table_id' => 5]);
    }

    public function test_it_shows_a_reservation()
    {
        $reservation = Reservation::factory()->create();
        $response = $this->getJson("/api/v1/reservations/{$reservation->id}");
        $response->assertStatus(200)->assertJsonFragment(['id' => $reservation->id]);
    }

    public function test_it_updates_a_reservation()
    {
        $reservation = Reservation::factory()->create(['status' => 'pending']);
        $response = $this->putJson("/api/v1/reservations/{$reservation->id}", [
            'status' => 'cancelled',
        ]);
        $response->assertStatus(200)->assertJsonFragment(['status' => 'cancelled']);
        $this->assertDatabaseHas('reservations', ['id' => $reservation->id, 'status' => 'cancelled']);
    }

    public function test_it_deletes_a_reservation()
    {
        $reservation = Reservation::factory()->create();
        $response = $this->deleteJson("/api/v1/reservations/{$reservation->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }
}
