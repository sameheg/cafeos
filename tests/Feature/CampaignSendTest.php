<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Modules\Crm\Jobs\SendCampaignJob;
use Modules\Crm\Models\Segment;
use Tests\TestCase;

class CampaignSendTest extends TestCase
{
    public function test_campaign_created_and_dispatched(): void
    {
        Queue::fake();

        Segment::create([
            'tenant_id' => (string) Str::uuid(),
            'name' => 'vip',
            'criteria' => ['rfm_score' => 5],
        ]);

        $response = $this->postJson('/v1/crm/campaigns', [
            'segment' => 'vip',
            'action' => 'send_voucher',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['campaign_id']);

        Queue::assertPushed(SendCampaignJob::class);
    }
}
