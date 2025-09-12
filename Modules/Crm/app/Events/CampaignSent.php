<?php

declare(strict_types=1);

namespace Modules\Crm\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Crm\Models\Campaign;

class CampaignSent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(public Campaign $campaign)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('crm');
    }

    public function broadcastAs(): string
    {
        return 'crm.campaign.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'campaign_id' => (string) $this->campaign->id,
            'segment' => $this->campaign->segment->name ?? '',
        ];
    }
}
