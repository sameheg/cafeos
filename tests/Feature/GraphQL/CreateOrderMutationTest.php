<?php

namespace Tests\Feature\GraphQL;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateOrderMutationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_users_can_create_order()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->accessToken;

        $mutation = 'mutation { createOrder(status: "done") { id status } }';

        $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson('/graphql', ['query' => $mutation])
            ->assertStatus(200);
    }
}
