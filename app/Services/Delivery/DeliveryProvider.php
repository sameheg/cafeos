<?php

namespace App\Services\Delivery;

interface DeliveryProvider
{
    /**
     * Fetch new orders from the remote service.
     *
     * @return array
     */
    public function fetchOrders(): array;

    /**
     * Update the status for a given order.
     */
    public function updateOrderStatus(string $orderId, string $status): bool;
}
