<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\LoyaltyService;
use App\Models\LoyaltyPoint;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoyaltyServiceTest extends TestCase
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
            'surname' => 'Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'john_doe',
            'email' => 'john@example.com',
            'password' => Hash::make('secret'),
        ]);
    }

    public function test_earn_points_increases_balance()
    {
        $user = $this->createUser();
        $service = new LoyaltyService();
        $service->earnPoints($user->id, 10);
        $this->assertEquals(10, $service->getPoints($user->id));
    }

    public function test_redeem_points_decreases_balance()
    {
        $user = $this->createUser();
        $service = new LoyaltyService();
        $service->earnPoints($user->id, 10);
        $service->redeemPoints($user->id, 4);
        $this->assertEquals(6, $service->getPoints($user->id));
    }
}
