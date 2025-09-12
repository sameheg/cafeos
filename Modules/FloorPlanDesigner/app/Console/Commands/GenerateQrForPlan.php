<?php

namespace Modules\FloorPlanDesigner\Console\Commands;

use Illuminate\Console\Command;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Modules\FloorPlanDesigner\Models\Furniture;

class GenerateQrForPlan extends Command
{
    protected $signature = 'floorplan:generate-qr {plan} {--base-url=https://example.com/qr}';
    protected $description = 'Generate QR URLs for each table furniture in a plan';

    public function handle(): int
    {
        $plan = Floorplan::findOrFail($this->argument('plan'));
        $base = rtrim($this->option('base-url'), '/');
        $count = 0;
        $tables = Furniture::where('plan_id',$plan->id)->where('type','table')->get();
        foreach ($tables as $t) {
            $qr = $base.'?tenant='.$plan->tenant_id.'&plan='.$plan->id.'&table='.($t->pos_table_id ?: $t->id);
            $t->update(['qr_url'=>$qr]);
            $count++;
        }
        $this->info('QR URLs assigned for '.$count.' tables.');
        return self::SUCCESS;
    }
}
