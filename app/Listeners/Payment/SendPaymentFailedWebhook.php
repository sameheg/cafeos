<?php

namespace App\Listeners\Payment;

use App\Events\Payment\PaymentFailed;
use App\Services\WebhookService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPaymentFailedWebhook implements ShouldQueue
{
    public function __construct(private WebhookService $webhookService) {}

    public function handle(PaymentFailed $event): void
    {
        $this->webhookService->send('payment_failed', [
            'transaction_uuid' => $event->transaction->uuid,
        ]);
    }
}
