<?php

namespace Modules\FloorPlanDesigner\Console\Commands;

use Illuminate\Console\Command;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Modules\FloorPlanDesigner\Models\Furniture;

class FloorplanSyncExport extends Command
{
    protected $signature = 'floorplan:sync-export {plan}';
    protected $description = 'Export normalized furniture into floorplans.json_data.furniture';

    public function handle(): int
    {
        $plan = Floorplan::findOrFail($this->argument('plan'));
        $items = Furniture::where('plan_id', $plan->id)->get()->map(function($f){
            return [
                'id' => (string)$f->id,
                'type' => $f->type,
                'x' => $f->x, 'y' => $f->y, 'w' => $f->w, 'h' => $f->h,
                'r' => $f->r, 'layer'=>$f->layer,
                'meta' => array_merge($f->meta ?? [], [
                    'name' => $f->name,
                    'cap' => $f->capacity,
                    'status' => $f->status,
                    'pos_table_id' => $f->pos_table_id,
                ]),
            ];
        })->values()->all();
        $data = $plan->json_data;
        $data['furniture'] = $items;
        $plan->json_data = $data;
        $plan->save();
        $this->info('Exported '.count($items).' items.');
        return self::SUCCESS;
    }
}
