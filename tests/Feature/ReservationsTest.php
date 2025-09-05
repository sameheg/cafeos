<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReservationsTest extends TestCase
{
    public function test_reservations_route_requires_authentication()
    {
        $response = $this->get('/bookings');
        $response->assertStatus(302);
    }
}
