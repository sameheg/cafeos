<?php

namespace Modules\FloorPlanDesigner\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\FloorPlanDesigner\Models\Floorplan;

class ActionsController
{
    public function publish(Floorplan $floorplan): JsonResponse
    {
        $floorplan->publish();
        return response()->json(['state' => $floorplan->state]);
    }

    public function archive(Floorplan $floorplan): JsonResponse
    {
        $floorplan->archive();
        return response()->json(['state' => $floorplan->state]);
    }

    public function schedule(Request $request, Floorplan $floorplan): JsonResponse
    {
        $data = $request->validate(['scheduled_at' => ['required', 'date']]);
        $floorplan->schedule(now()->parse($data['scheduled_at']));
        return response()->json(['scheduled_at' => $floorplan->scheduled_at]);
    }
}
