<?php

namespace Modules\Kds\Listeners;

use Modules\Pos\Events\OrderCreated;
use Modules\Kds\Models\KitchenTicket;

class CreateKitchenTicket
{
    public function handle(OrderCreated $event): void
    {
        KitchenTicket::create([
            'order_id' => $event->order->id,
            'status' => 'pending',
            'approved' => true,
        ]);
    }
}
