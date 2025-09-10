<?php

namespace Modules\Kds\Listeners;

use Modules\Kds\Models\KitchenTicket;
use Modules\Pos\Events\OrderCreated;

class CreateKitchenTicket
{
    public function handle(OrderCreated $event): void
    {
        KitchenTicket::create([
            'order_id' => $event->order->id,
            'status' => 'pending',
            'approved' => false,
        ]);
    }
}
