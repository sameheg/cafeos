<?php

namespace Modules\FloorPlanDesigner\Http\Controllers\Enterprise;

use Illuminate\Http\JsonResponse;
use Modules\FloorPlanDesigner\Models\Floorplan;

class SalesHeatmapController
{
    public function __invoke(Floorplan $floorplan): JsonResponse
    {
        // TODO: aggregate from POS order items; placeholder static grid
        $points = [[10,10,2],[120,90,5],[300,220,3],[450,150,7]];
        return response()->json(['data'=>$points]);
    }
}
