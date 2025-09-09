<?php

namespace Modules\Crm\Contracts;

use Illuminate\Support\Collection;

interface OrderHistoryServiceInterface
{
    /**
     * Get the order history for the given customer.
     */
    public function getOrders(int|string $customerId): Collection;
}
