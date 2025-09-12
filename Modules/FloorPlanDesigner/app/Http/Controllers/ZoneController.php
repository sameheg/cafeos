<?php

namespace Modules\FloorPlanDesigner\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Modules\FloorPlanDesigner\Models\FloorplanZone;

class ZoneController
{
    public function index(Floorplan $floorplan): JsonResponse
    {
        return response()->json(['data' => $floorplan->zones()->get()]);
    }

    public function store(Request $request, Floorplan $floorplan): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'coords' => ['required', 'array'],
        ]);
        $zone = $floorplan->zones()->create([
            'tenant_id' => $floorplan->tenant_id,
            'name' => $validated['name'],
            'coords' => $validated['coords'],
        ]);
        return response()->json(['data' => $zone], 201);
    }

    public function update(Request $request, Floorplan $floorplan, FloorplanZone $zone): JsonResponse
    {
        abort_unless($zone->plan_id === $floorplan->id, 404);
        $validated = $request->validate([
            'name' => ['sometimes', 'string'],
            'coords' => ['sometimes', 'array'],
        ]);
        $zone->update($validated);
        return response()->json(['data' => $zone]);
    }

    public function destroy(Floorplan $floorplan, FloorplanZone $zone): JsonResponse
    {
        abort_unless($zone->plan_id === $floorplan->id, 404);
        $zone->delete();
        return response()->json(['deleted' => true]);
    }
}
