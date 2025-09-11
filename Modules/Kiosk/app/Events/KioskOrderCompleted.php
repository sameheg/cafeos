<?php

namespace Modules\Kiosk\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Kiosk\Models\KioskOrder;

class KioskOrderCompleted
{
    use Dispatchable, SerializesModels;

    public string $kiosk_id;
    public string $order_id;

    public function __construct(KioskOrder $order)
    {
        $this->kiosk_id = $order->kiosk_id;
        $this->order_id = $order->id;
    }

    public function broadcastAs(): string
    {
        return 'kiosk.order.completed@v1';
    }

    public function toArray(): array
    {
        return [
            'kiosk_id' => $this->kiosk_id,
            'order_id' => $this->order_id,
        ];
    }
}
