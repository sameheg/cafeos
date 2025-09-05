<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\LoyaltyService;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoyaltyFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');
    }

    protected function createUser()
    {
        return User::create([
            'surname' => 'Smith',
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'username' => 'alice',
            'email' => 'alice@example.com',
            'password' => Hash::make('secret'),
        ]);
    }

    public function test_user_can_view_loyalty_balance()
    {
        $user = $this->createUser();
        $service = new LoyaltyService();
        $service->earnPoints($user->id, 5);

        $response = $this->actingAs($user)->get('/loyalty');
        $response->assertStatus(200);
        $response->assertSee('Your balance: 5');
    }

    public function test_user_can_redeem_points()
    {
        $user = $this->createUser();
        $service = new LoyaltyService();
        $service->earnPoints($user->id, 5);

        $response = $this->actingAs($user)->post('/loyalty/redeem', ['points' => 3]);
        $response->assertRedirect('/loyalty');
        $this->assertEquals(2, $service->getPoints($user->id));
    }
}
