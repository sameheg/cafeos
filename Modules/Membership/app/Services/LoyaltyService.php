<?php

namespace Modules\Membership\Services;

use Modules\Membership\Contracts\LoyaltyServiceInterface;

class LoyaltyService implements LoyaltyServiceInterface
{
    public function getPoints(int|string $customerId): int
    {
        return 0;
    }
}
