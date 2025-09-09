<?php

namespace Modules\Membership\Services;

use Modules\Membership\Contracts\LoyaltyServiceInterface;
use Modules\Membership\Events\SubscriptionExpiring;
use Illuminate\Support\Carbon;

class LoyaltyService implements LoyaltyServiceInterface
{
    public function getPoints(int|string $customerId): int
    {
        return 0;
    }

    public function checkSubscriptionExpiry(int|string $customerId, Carbon $expiresAt): void
    {
        if ($expiresAt->diffInDays(now()) <= 7) {
            event(new SubscriptionExpiring($customerId, $expiresAt));
        }
    }
}
