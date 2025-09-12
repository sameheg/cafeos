<?php
namespace Modules\Reservations\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class ReservationGuardTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_blocks_opening_order_on_reserved_table()
    {
        DB::table('reservations')->insert([
            'tenant_id' => 1,
            'table_id' => 10,
            'status' => 'confirmed',
            'start_at' => now()->subMinutes(5),
            'end_at' => now()->addMinutes(30),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->postJson('/api/v1/pos/tables/start', [
            'table_id' => 10,
        ]);

        $response->assertStatus(409);
        $response->assertJson(['code' => 'RESERVATION_CONFLICT']);
    }

    public function test_it_allows_opening_order_if_no_conflict()
    {
        $response = $this->postJson('/api/v1/pos/tables/start', [
            'table_id' => 99,
        ]);

        $response->assertStatus(201);
    }
}
