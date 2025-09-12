<?php

namespace Modules\Membership\Tests\Unit;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Modules\Membership\Events\TierUpgraded;
use Modules\Membership\Models\Membership;
use Tests\TestCase;

class TierUpgradeTest extends TestCase
{
    public function test_tier_upgrade_dispatches_event(): void
    {
        Event::fake([TierUpgraded::class]);

        $membership = Membership::create([
            'tenant_id' => (string) Str::uuid(),
            'customer_id' => (string) Str::uuid(),
            'tier' => 'silver',
            'expiry' => now()->addMonth(),
            'status' => 'active',
        ]);

        $membership->update(['tier' => 'gold']);

        Event::assertDispatched(TierUpgraded::class);
    }
}
