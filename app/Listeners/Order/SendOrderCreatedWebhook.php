<?php

namespace App\Listeners\Order;

use App\Events\Order\OrderCreated;
use App\Services\WebhookService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderCreatedWebhook implements ShouldQueue
{
    public function __construct(private WebhookService $webhookService) {}

    public function handle(OrderCreated $event): void
    {
        $this->webhookService->send('order_created', [
            'order_uuid' => $event->order->uuid,
        ]);
    }
}
