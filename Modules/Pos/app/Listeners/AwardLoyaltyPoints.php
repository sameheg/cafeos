<?php

namespace Modules\Pos\Listeners;

use Modules\Loyalty\Contracts\LoyaltyServiceInterface;
use Modules\Membership\Enums\MembershipTier;
use Modules\Pos\Events\OrderCreated;

class AwardLoyaltyPoints
{
    public function __construct(private LoyaltyServiceInterface $loyalty)
    {
    }

    public function handle(OrderCreated $event): void
    {
        $customerId = $event->order->customer_id ?? null;
        if ($customerId) {
            $points = (int) $event->order->total;
            $this->loyalty->accruePoints($customerId, $points, $event->tenant?->id, MembershipTier::BRONZE);
        }
    }
}
