<?php

namespace App\Listeners\Device;

use App\Events\Device\DeviceAlert;
use App\Services\WebhookService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDeviceAlertWebhook implements ShouldQueue
{
    public function __construct(private WebhookService $webhookService) {}

    public function handle(DeviceAlert $event): void
    {
        $this->webhookService->send('device_alert', [
            'device_id' => $event->deviceId,
            'message' => $event->message,
        ]);
    }
}
