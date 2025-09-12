<?php

namespace Modules\HotelPms\Listeners;

use Modules\Pos\Events\OrderPaid;
use Modules\HotelPms\Models\Folio;
use Illuminate\Support\Str;

class HandleOrderPaid
{
    public function handle(OrderPaid $event): void
    {
        $order = $event->order;

        Folio::create([
            'tenant_id' => $order->tenant_id ?? (string) Str::uuid(),
            'guest_id' => $order->table_id ?? 'guest',
            'total' => $order->total,
            'status' => Folio::STATUS_POSTED,
        ]);
    }
}
