<?php

namespace Modules\Membership\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Membership\Models\Membership;

class TierUpgraded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Membership $membership)
    {
    }

    public function toBroadcast(): array
    {
        return [
            'event' => 'membership.tier.upgraded',
            'data' => [
                'member_id' => (string) $this->membership->id,
                'tier' => $this->membership->tier,
            ],
        ];
    }
}
