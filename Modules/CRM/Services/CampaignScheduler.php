<?php

namespace Modules\CRM\Services;

use App\Services\OpenAIService;
use Modules\CRM\Jobs\SendCampaignMessage;

class CampaignScheduler
{
    public function __construct(private OpenAIService $openAI)
    {
    }

    public function schedule(string $channel, string $prompt, array $recipients, ?\DateTimeInterface $when = null): void
    {
        $content = $this->openAI->generateCampaignContent($prompt);

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
