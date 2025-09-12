<?php

namespace Modules\FloorPlanDesigner\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\FloorPlanDesigner\Models\Floorplan;

class FloorPlanDesignerSeeder extends Seeder
{
    public function run(): void
    {
        Floorplan::create([
            'tenant_id' => 'seed-tenant',
            'json_data' => ['tables' => [1,2]],
            'version' => 1,
            'state' => 'draft',
        ]);
    }
}
