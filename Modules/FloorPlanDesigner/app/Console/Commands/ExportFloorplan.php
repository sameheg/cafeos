<?php

namespace Modules\FloorPlanDesigner\Console\Commands;

use Illuminate\Console\Command;
use Modules\FloorPlanDesigner\Models\Floorplan;

class ExportFloorplan extends Command
{
    protected $signature = 'floorplan:export {id}';
    protected $description = 'Export a floorplan as JSON';

    public function handle(): int
    {
        $plan = Floorplan::with('zones')->findOrFail($this->argument('id'));
        $this->line(json_encode(['plan' => $plan, 'zones' => $plan->zones], JSON_PRETTY_PRINT));
        return self::SUCCESS;
    }
}
