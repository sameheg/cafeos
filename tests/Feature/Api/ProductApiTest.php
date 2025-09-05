<?php

namespace Tests\Feature\Api;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_products()
    {
        $this->getJson('/api/products')->assertStatus(401);
    }

    /** @test */
    public function authenticated_users_can_list_products()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->accessToken;

        $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->getJson('/api/products')
            ->assertStatus(200);
    }
}
