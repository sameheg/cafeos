<?php

namespace Modules\Membership\Tests\Contract;

use Illuminate\Support\Str;
use Modules\Membership\Events\TierUpgraded;
use Modules\Membership\Models\Membership;
use PHPUnit\Framework\TestCase;

class MembershipEventSchemaTest extends TestCase
{
    public function test_matches_tier_upgraded_schema(): void
    {
        $membership = new Membership([
            'id' => Str::ulid(),
            'tier' => 'gold',
        ]);

        $event = new TierUpgraded($membership);

        $this->assertEquals(
            [
                'event' => 'membership.tier.upgraded',
                'data' => [
                    'member_id' => $membership->id,
                    'tier' => 'gold',
                ],
            ],
            $event->toBroadcast()
        );
    }
}
