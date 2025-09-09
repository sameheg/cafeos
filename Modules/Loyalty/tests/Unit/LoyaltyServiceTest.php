<?php

namespace Modules\Loyalty\Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Loyalty\Contracts\LoyaltyServiceInterface;
use Modules\Loyalty\Providers\LoyaltyServiceProvider;
use Modules\Membership\Enums\MembershipTier;
use Tests\TestCase;

class LoyaltyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(LoyaltyServiceProvider::class);
    }

    public function test_it_applies_tier_multiplier(): void
    {
        User::factory()->create(['id' => 1, 'tenant_id' => 1]);
        $service = $this->app->make(LoyaltyServiceInterface::class);
        $service->accruePoints(1, 100, null, MembershipTier::GOLD);
        $this->assertSame(125, $service->getPoints(1));
    }
}
