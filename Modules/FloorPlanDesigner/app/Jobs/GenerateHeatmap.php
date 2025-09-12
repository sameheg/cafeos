<?php

namespace Modules\FloorPlanDesigner\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\FloorPlanDesigner\Models\Floorplan;

class GenerateHeatmap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $planId) {}

    public function handle(): void
    {
        $plan = Floorplan::find($this->planId);
        if (!$plan) return;
        $data = $plan->json_data;
        $data['heatmap'] = $data['heatmap'] ?? [[10,10,1],[50,50,3],[100,80,2]];
        $plan->json_data = $data;
        $plan->save();
    }
}
