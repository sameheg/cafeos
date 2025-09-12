<?php

namespace Modules\Notifications\Listeners;

use Modules\Core\Events\JsonDomainEvent;
use Modules\Notifications\Models\NotificationTemplate;
use Modules\Notifications\Services\NotificationSender;

class CampaignSentListener
{
    public function __construct(protected NotificationSender $sender) {}

    public function handle(JsonDomainEvent $event): void
    {
        if ($event->event !== 'crm.campaign.sent@v1') {
            return;
        }

        $templateId = $event->data['template_id'] ?? null;
        $recipients = $event->data['recipients'] ?? [];
        if (! $templateId || empty($recipients)) {
            return;
        }

        $template = NotificationTemplate::find($templateId);
        if ($template) {
            $this->sender->send($template, $recipients);
        }
    }
}
