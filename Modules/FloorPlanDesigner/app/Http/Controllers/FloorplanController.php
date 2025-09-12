<?php

namespace Modules\FloorPlanDesigner\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\FloorPlanDesigner\Http\Requests\UpdateFloorplanRequest;
use Modules\FloorPlanDesigner\Models\Floorplan;

class FloorplanController
{
    public function update(UpdateFloorplanRequest $request, Floorplan $floorplan): JsonResponse
    {
        $floorplan->json_data = $request->input('json_data');
        $floorplan->save();

        return response()->json(['updated' => true]);
    }

    public function heatmap(Floorplan $floorplan): JsonResponse
    {
        if (! config('floorplandesigner.feature_flags.floorplan_heatmaps')) {
            abort(404);
        }

        $data = $floorplan->json_data['heatmap'] ?? [];
        return response()->json(['data' => $data]);
    }
}
