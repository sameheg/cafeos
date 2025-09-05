<?php

namespace App\Services;

use App\Events\KdsTicketReady;
use App\Restaurant\TableOrder;
use Illuminate\Support\Facades\Log;

class WaiterNotificationService
{
    public function notifyTicketReady(TableOrder $order): void
    {
        try {
            event(new KdsTicketReady($order));
        } catch (\Throwable $e) {
            Log::error('Failed to notify waiter', ['order_id' => $order->id, 'error' => $e->getMessage()]);
            $this->fallback($order);
        }
    }

    protected function fallback(TableOrder $order): void
    {
        $order->status = 'pending';
        $order->save();
    }
}
