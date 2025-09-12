<?php

namespace Modules\FloorPlanDesigner\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Illuminate\Support\Carbon;

class ComputeFloorplanStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $planId, public ?string $date = null) {}

    public function handle(): void
    {
        // NOTE: In real integration, aggregate from POS orders.
        $date = $this->date ? Carbon::parse($this->date)->toDateString() : now()->toDateString();
        \DB::table('floorplan_stats')->updateOrInsert(
            ['date'=>$date,'plan_id'=>$this->planId,'tenant_id'=>\DB::table('floorplans')->where('id',$this->planId)->value('tenant_id')],
            ['order_count'=>0,'revenue'=>0,'avg_spend'=>0,'turnover'=>0,'hot_index'=>0,'updated_at'=>now(),'created_at'=>now()]
        );
    }
}
