<?php

namespace Modules\Crm\Services;

use Illuminate\Support\Collection;
use Modules\Crm\Contracts\OrderHistoryServiceInterface;
use Modules\Pos\Models\Order;

class OrderHistoryService implements OrderHistoryServiceInterface
{
    public function getOrders(int|string $customerId): Collection
    {
        return Order::where('customer_id', $customerId)->get();
    }
}
