<?php

namespace Modules\Membership\Contracts;

interface LoyaltyServiceInterface
{
    public function getPoints(int|string $customerId): int;
}
