<?php

declare(strict_types=1);

namespace Modules\Crm\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Crm\Events\CampaignSent;
use Modules\Crm\Models\Campaign;

class SendCampaignJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Campaign $campaign)
    {
    }

    public function handle(): void
    {
        $this->campaign->update(['status' => 'sent']);

        event(new CampaignSent($this->campaign));
    }
}
