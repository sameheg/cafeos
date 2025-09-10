<?php

namespace App\Services\DeliveryAggregators;

use App\Contracts\DeliveryAggregator;

class TalabatService implements DeliveryAggregator
{
    public function pushOrder(array $order): void
    {
        // TODO: Integrate with Talabat API
    }
}

