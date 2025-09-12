<?php

namespace Modules\FloorPlanDesigner\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\FloorPlanDesigner\Models\Floorplan;

class ExportImportController
{
    public function export(Floorplan $floorplan): JsonResponse
    {
        return response()->json([
            'plan' => $floorplan->toArray(),
            'zones' => $floorplan->zones()->get()->toArray(),
        ]);
    }

    public function import(Request $request): JsonResponse
    {
        $data = $request->validate([
            'plan.tenant_id' => ['required', 'string'],
            'plan.json_data' => ['required', 'array'],
            'plan.version' => ['required', 'integer'],
            'plan.state' => ['required', 'string'],
            'zones' => ['array'],
        ]);
        $plan = Floorplan::create([
            'tenant_id' => $data['plan']['tenant_id'],
            'json_data' => $data['plan']['json_data'],
            'version' => $data['plan']['version'],
            'state' => $data['plan']['state'],
        ]);
        foreach ($data['zones'] ?? [] as $z) {
            $plan->zones()->create([
                'tenant_id' => $plan->tenant_id,
                'name' => $z['name'] ?? 'Zone',
                'coords' => $z['coords'] ?? [],
            ]);
        }
        return response()->json(['plan_id' => $plan->id], 201);
    }
}
