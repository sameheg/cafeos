<?php

namespace Modules\Kds\Listeners;

use Illuminate\Support\Carbon;
use Modules\Kds\Models\KdsTicket;
use Modules\Pos\Events\OrderPaid;

class CreateTicket
{
    public function handle(OrderPaid $event): void
    {
        $order = $event->order;
        KdsTicket::create([
            'tenant_id' => $order->tenant_id,
            'order_id' => $order->id,
            'station' => 'hot',
            'sla_time' => Carbon::now()->addMinutes(10),
        ]);
    }
}
