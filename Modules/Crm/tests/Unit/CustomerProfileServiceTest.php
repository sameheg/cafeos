<?php

namespace Modules\Crm\Tests\Unit;

use Modules\Crm\Contracts\CustomerProfileServiceInterface;
use Modules\Crm\Providers\CrmServiceProvider;
use Modules\Loyalty\Contracts\LoyaltyServiceInterface;
use Modules\Membership\Enums\MembershipTier;
use Tests\TestCase;

class CustomerProfileServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(CrmServiceProvider::class);
    }

    public function test_it_returns_profile_with_points_and_tier(): void
    {
        $loyalty = \Mockery::mock(LoyaltyServiceInterface::class);
        $loyalty->shouldReceive('getPoints')->once()->with(1)->andReturn(10);
        $this->app->instance(LoyaltyServiceInterface::class, $loyalty);

        $service = $this->app->make(CustomerProfileServiceInterface::class);
        $profile = $service->getProfile(1);

        $this->assertSame(10, $profile['points']);
        $this->assertSame('bronze', $profile['tier']);
    }

    public function test_it_upgrades_and_downgrades_tier(): void
    {
        $loyalty = \Mockery::mock(LoyaltyServiceInterface::class);
        $loyalty->shouldReceive('getPoints')->andReturn(0);
        $this->app->instance(LoyaltyServiceInterface::class, $loyalty);

        $service = $this->app->make(CustomerProfileServiceInterface::class);
        $this->assertSame('silver', $service->upgradeTier(1)->value);
        $this->assertSame('gold', $service->upgradeTier(1)->value);
        $this->assertSame('silver', $service->downgradeTier(1)->value);
    }
}
