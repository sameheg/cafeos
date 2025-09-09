<?php

namespace Modules\TableReservations\Tests\Unit;

use Modules\Membership\Enums\MembershipTier;
use Modules\TableReservations\Models\WaitlistEntry;
use Tests\TestCase;

class WaitlistEntryTest extends TestCase
{
    public function test_priority_reflects_membership_tier(): void
    {
        $gold = new WaitlistEntry(['membership_tier' => MembershipTier::GOLD]);
        $silver = new WaitlistEntry(['membership_tier' => MembershipTier::SILVER]);
        $bronze = new WaitlistEntry(['membership_tier' => MembershipTier::BRONZE]);

        $this->assertGreaterThan($silver->priority, $gold->priority);
        $this->assertGreaterThan($bronze->priority, $silver->priority);
    }
}
