<?php

namespace Modules\Crm\Services;

use Modules\Crm\Contracts\CustomerProfileServiceInterface;
use Modules\Loyalty\Contracts\LoyaltyServiceInterface;
use Modules\Membership\Enums\MembershipTier;

class CustomerProfileService implements CustomerProfileServiceInterface
{
    /** @var array<int|string, MembershipTier> */
    private array $tiers = [];

    public function __construct(private LoyaltyServiceInterface $loyalty) {}

    public function getProfile(int|string $customerId): array
    {
        return [
            'id' => $customerId,
            'points' => $this->loyalty->getPoints($customerId),
            'tier' => ($this->tiers[$customerId] ?? MembershipTier::BRONZE)->value,
        ];
    }

    public function upgradeTier(int|string $customerId): MembershipTier
    {
        $current = $this->tiers[$customerId] ?? MembershipTier::BRONZE;

        return $this->tiers[$customerId] = $current->next();
    }

    public function downgradeTier(int|string $customerId): MembershipTier
    {
        $current = $this->tiers[$customerId] ?? MembershipTier::BRONZE;

        return $this->tiers[$customerId] = $current->previous();
    }
}
