<?php

namespace Tests\Feature\GraphQL;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductQueryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_query_products()
    {
        $query = '{ product { id name } }';
        $this->postJson('/graphql', ['query' => $query])->assertStatus(401);
    }

    /** @test */
    public function authenticated_users_can_query_products()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->accessToken;

        $query = '{ product { id name } }';

        $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson('/graphql', ['query' => $query])
            ->assertStatus(200);
    }
}
