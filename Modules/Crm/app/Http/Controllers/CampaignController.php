<?php

declare(strict_types=1);

namespace Modules\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Crm\Jobs\SendCampaignJob;
use Modules\Crm\Models\Campaign;
use Modules\Crm\Models\Segment;

class CampaignController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'segment' => ['required', 'string'],
            'action' => ['required', 'string'],
        ]);

        $segment = Segment::where('name', $data['segment'])->firstOrFail();

        $campaign = Campaign::create([
            'tenant_id' => $segment->tenant_id,
            'segment_id' => $segment->id,
        ]);

        SendCampaignJob::dispatch($campaign);

        return response()->json(['campaign_id' => (string) $campaign->id]);
    }
}
