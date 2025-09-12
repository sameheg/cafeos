<?php

namespace Modules\FloorPlanDesigner\Console\Commands;

use Illuminate\Console\Command;
use Modules\FloorPlanDesigner\Models\Floorplan;

class ImportFloorplan extends Command
{
    protected $signature = 'floorplan:import {file}';
    protected $description = 'Import a floorplan JSON from file';

    public function handle(): int
    {
        $file = $this->argument('file');
        $data = json_decode(file_get_contents($file), true);
        $plan = Floorplan::create($data['plan']);
        foreach ($data['zones'] ?? [] as $z) {
            $plan->zones()->create($z + ['tenant_id' => $plan->tenant_id]);
        }
        $this->info('Imported plan: ' . $plan->id);
        return self::SUCCESS;
    }
}
