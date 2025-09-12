<?php

namespace Modules\FloorPlanDesigner\Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        if (!class_exists(\Spatie\Permission\Models\Permission::class)) {
            return;
        }
        $P = \Spatie\Permission\Models\Permission::class;
        foreach ([
            'floorplan.view','floorplan.create','floorplan.update','floorplan.delete',
            'floorplan.zone.view','floorplan.zone.create','floorplan.zone.update','floorplan.zone.delete',
        ] as $p) {
            $P::findOrCreate($p, 'web');
        }
    }
}
