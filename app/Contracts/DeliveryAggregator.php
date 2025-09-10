<?php

namespace App\Contracts;

interface DeliveryAggregator
{
    /**
     * Push an order to the external delivery service.
     *
     * @param array $order
     */
    public function pushOrder(array $order): void;
}

