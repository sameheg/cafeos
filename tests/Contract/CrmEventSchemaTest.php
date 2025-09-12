<?php

declare(strict_types=1);

namespace Tests\Contract;

use Illuminate\Support\Str;
use Modules\Crm\Events\CampaignSent;
use Modules\Crm\Models\Campaign;
use Modules\Crm\Models\Segment;
use Tests\TestCase;

class CrmEventSchemaTest extends TestCase
{
    public function test_campaign_sent_schema(): void
    {
        $segment = Segment::create([
            'tenant_id' => (string) Str::uuid(),
            'name' => 'high_value',
            'criteria' => ['rfm_score' => 5],
        ]);

        $campaign = Campaign::create([
            'tenant_id' => $segment->tenant_id,
            'segment_id' => $segment->id,
        ]);

        $event = new CampaignSent($campaign->setRelation('segment', $segment));
        $payload = $event->broadcastWith();

        $this->assertSame((string) $campaign->id, $payload['campaign_id']);
        $this->assertSame('high_value', $payload['segment']);
    }
}
