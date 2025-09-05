<?php

namespace App\Services\Delivery;

interface DeliveryProvider
{
    /**
     * Create a new order on the delivery service.
     *
     * @param array $data
     * @return string Remote order identifier
     */
    public function createOrder(array $data): string;

    /**
     * Update an existing order on the delivery service.
     */
    public function updateOrder(string $orderId, array $data): bool;
}
