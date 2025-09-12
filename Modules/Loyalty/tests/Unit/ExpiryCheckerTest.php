<?php

namespace Modules\Loyalty\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Loyalty\Jobs\ExpirePointsJob;
use Modules\Loyalty\Models\LoyaltyPoint;
use Tests\TestCase;

class ExpiryCheckerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_expires_points(): void
    {
        $wallet = LoyaltyPoint::create([
            'tenant_id' => 'tenant-demo',
            'customer_id' => 'cust-1',
            'balance' => 50,
            'expiry' => now()->subDay(),
        ]);

        (new ExpirePointsJob())->handle();

        $this->assertDatabaseHas('loyalty_points', [
            'id' => $wallet->id,
            'balance' => 0,
        ]);
    }
}
