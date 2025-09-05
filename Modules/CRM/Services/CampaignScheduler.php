<?php

namespace Modules\CRM\Services;

use Modules\CRM\Jobs\SendCampaignMessage;

class CampaignScheduler
{
    public function schedule(string $channel, string $content, array $recipients, ?\DateTimeInterface $when = null): void
    {
        foreach ($recipients as $recipient) {
            $job = new SendCampaignMessage($channel, $recipient, $content);

            if ($when) {
                dispatch($job)->delay($when);
            } else {
                dispatch($job);
            }
        }
    }
}
