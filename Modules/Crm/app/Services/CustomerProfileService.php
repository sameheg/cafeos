<?php

namespace Modules\Crm\Services;

use Modules\Crm\Contracts\CustomerProfileServiceInterface;
use Modules\Membership\Contracts\LoyaltyServiceInterface;

class CustomerProfileService implements CustomerProfileServiceInterface
{
    public function __construct(private LoyaltyServiceInterface $loyalty)
    {
    }

    public function getProfile(int|string $customerId): array
    {
        return [
            'id' => $customerId,
            'points' => $this->loyalty->getPoints($customerId),
        ];
    }
}
