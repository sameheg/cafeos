<?php

namespace Modules\Crm\Contracts;

interface CustomerProfileServiceInterface
{
    /**
     * Retrieve customer's profile information including loyalty points.
     */
    public function getProfile(int|string $customerId): array;
}
