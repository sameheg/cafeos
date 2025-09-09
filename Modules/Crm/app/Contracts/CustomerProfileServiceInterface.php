<?php

namespace Modules\Crm\Contracts;

use Modules\Membership\Enums\MembershipTier;

interface CustomerProfileServiceInterface
{
    /**
     * Retrieve customer's profile information including loyalty points and tier.
     */
    public function getProfile(int|string $customerId): array;

    /** Upgrade customer to next membership tier. */
    public function upgradeTier(int|string $customerId): MembershipTier;

    /** Downgrade customer to previous membership tier. */
    public function downgradeTier(int|string $customerId): MembershipTier;
}
