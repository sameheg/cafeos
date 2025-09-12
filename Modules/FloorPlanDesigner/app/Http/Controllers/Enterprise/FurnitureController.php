<?php

namespace Modules\FloorPlanDesigner\Http\Controllers\Enterprise;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\FloorPlanDesigner\Models\Floorplan;
use Modules\FloorPlanDesigner\Models\Furniture;
use Modules\FloorPlanDesigner\Events\FurnitureCreated;
use Modules\FloorPlanDesigner\Events\FurnitureUpdated;
use Modules\FloorPlanDesigner\Events\FurnitureDeleted;

class FurnitureController
{
    public function index(Floorplan $floorplan): JsonResponse
    {
        $items = Furniture::where('plan_id', $floorplan->id)->orderBy('layer')->get();
        return response()->json(['data' => $items]);
    }

    public function store(Request $req, Floorplan $floorplan): JsonResponse
    {
        $data = $req->validate([
            'type' => 'required|string',
            'name' => 'required|string',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'nullable|string',
            'x' => 'required|integer', 'y' => 'required|integer',
            'w' => 'nullable|integer', 'h' => 'nullable|integer',
            'r' => 'nullable|integer', 'layer' => 'nullable|integer',
            'pos_table_id' => 'nullable|string',
            'meta' => 'array'
        ]);
        $data['tenant_id'] = $floorplan->tenant_id;
        $data['plan_id'] = $floorplan->id;
        $f = Furniture::create($data);
        event(new FurnitureCreated($f));
        return response()->json(['data' => $f], 201);
    }

    public function update(Request $req, Floorplan $floorplan, Furniture $furniture): JsonResponse
    {
        abort_unless($furniture->plan_id === $floorplan->id, 404);
        $data = $req->validate([
            'name' => 'sometimes|string',
            'capacity' => 'sometimes|integer|min:1',
            'status' => 'sometimes|string',
            'x' => 'sometimes|integer', 'y' => 'sometimes|integer',
            'w' => 'sometimes|integer', 'h' => 'sometimes|integer',
            'r' => 'sometimes|integer', 'layer' => 'sometimes|integer',
            'pos_table_id' => 'sometimes|string',
            'meta' => 'sometimes|array'
        ]);
        $furniture->update($data);
        event(new FurnitureUpdated($furniture));
        return response()->json(['data' => $furniture]);
    }

    public function destroy(Floorplan $floorplan, Furniture $furniture): JsonResponse
    {
        abort_unless($furniture->plan_id === $floorplan->id, 404);
        $furniture->delete();
        event(new FurnitureDeleted($furniture));
        return response()->json(['deleted' => true]);
    }

    public function batchSave(Request $req, Floorplan $floorplan): JsonResponse
    {
        $payload = $req->validate([
            'items' => 'required|array',
            'items.*.id' => 'nullable|string',
            'items.*.type' => 'required|string',
            'items.*.name' => 'required|string',
            'items.*.capacity' => 'nullable|integer|min:1',
            'items.*.status' => 'nullable|string',
            'items.*.x' => 'required|integer', 'items.*.y' => 'required|integer',
            'items.*.w' => 'nullable|integer', 'items.*.h' => 'nullable|integer',
            'items.*.r' => 'nullable|integer', 'items.*.layer' => 'nullable|integer',
            'items.*.pos_table_id' => 'nullable|string',
            'items.*.meta' => 'array'
        ]);
        $tenant = $floorplan->tenant_id;
        $ids = [];
        foreach ($payload['items'] as $it) {
            $it['tenant_id'] = $tenant;
            $it['plan_id'] = $floorplan->id;
            if (!empty($it['id'])) {
                $f = \Modules\FloorPlanDesigner\Models\Furniture::find($it['id']);
                if ($f) { $f->update($it); event(new FurnitureUpdated($f)); $ids[] = (string)$f->id; continue; }
            }
            $f = \Modules\FloorPlanDesigner\Models\Furniture::create($it);
            event(new FurnitureCreated($f));
            $  # placeholder to avoid Python formatting
        }
        $items = \Modules\FloorPlanDesigner\Models\Furniture::where('plan_id',$floorplan->id)->orderBy('layer')->get();
        return response()->json(['data'=>$items]);
    }
}
