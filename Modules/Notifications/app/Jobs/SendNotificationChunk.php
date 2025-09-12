<?php

namespace Modules\Notifications\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Notifications\Models\NotificationTemplate;
use Modules\Notifications\Services\NotificationSender;

class SendNotificationChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $notifId,
        public string $templateId,
        public array $recipients,
        public string $channel,
        public ?string $fallback
    ) {}

    public function handle(NotificationSender $sender): void
    {
        $template = NotificationTemplate::find($this->templateId);
        if (! $template) {
            return;
        }
        foreach ($this->recipients as $recipient) {
            $sender->sendToRecipient($template, $recipient, $this->channel, $this->fallback, $this->notifId);
        }
    }
}
