<?php

namespace Modules\FloorPlanDesigner\Console\Commands;

use Illuminate\Console\Command;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Modules\FloorPlanDesigner\Models\Furniture;

class FloorplanSyncImport extends Command
{
    protected $signature = 'floorplan:sync-import {plan}';
    protected $description = 'Import furniture from floorplans.json_data.furniture into normalized table';

    public function handle(): int
    {
        $plan = Floorplan::findOrFail($this->argument('plan'));
        $items = $plan->json_data['furniture'] ?? [];
        foreach ($items as $t) {
            Furniture::updateOrCreate(
                ['plan_id'=>$plan->id,'name'=>$t['meta']['name'] ?? $t['type']],
                [
                    'tenant_id'=>$plan->tenant_id,
                    'type'=>$t['type'] ?? 'table',
                    'capacity'=>$t['meta']['cap'] ?? 2,
                    'status'=>$t['meta']['status'] ?? 'available',
                    'x'=>$t['x'] ?? 0,'y'=>$t['y'] ?? 0,'w'=>$t['w'] ?? 80,'h'=>$t['h'] ?? 60,
                    'r'=>$t['r'] ?? 0,'layer'=>$t['layer'] ?? 0,
                    'pos_table_id'=>$t['meta']['pos_table_id'] ?? null,
                    'meta'=>$t['meta'] ?? [],
                ]
            );
        }
        $this->info('Imported '.count($items).' items.');
        return self::SUCCESS;
    }
}
