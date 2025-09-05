<?php

namespace Tests\Feature\Api;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_orders()
    {
        $this->getJson('/api/orders')->assertStatus(401);
    }

    /** @test */
    public function authenticated_users_can_list_orders()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->accessToken;

        $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->getJson('/api/orders')
            ->assertStatus(200);
    }
}
