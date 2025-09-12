<?php

namespace Modules\Reservations\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Reservations\Models\ReservationSlot;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_book_and_checkin(): void
    {
        \Modules\Core\Models\Tenant::forceCreate(['id' => 't1', 'name' => 'Tenant', 'subdomain' => 't1']);
        app()->instance('tenant', \Modules\Core\Models\Tenant::find('t1'));
        $date = now()->addDay();
        ReservationSlot::create(['tenant_id' => 't1', 'date' => $date->toDateString(), 'capacity' => 2]);

        $response = $this->postJson('/api/v1/reservations', [
            'tenant_id' => 't1',
            'time' => $date->copy()->setTime(10, 0)->toDateTimeString(),
            'table_id' => 'A1',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['res_id']);
        $resId = $response->json('res_id');

        $checkin = $this->patchJson("/api/v1/reservations/{$resId}/checkin");
        $checkin->assertStatus(200)->assertJson(['checked_in' => true]);
    }
}
