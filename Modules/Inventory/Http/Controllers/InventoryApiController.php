<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Inventory\Services\MovementService;
use Modules\Inventory\Services\InventoryLevelService;

class InventoryApiController extends Controller
{
    public function recordMovement(Request $request, MovementService $service)
    {
        $data = $request->validate([
            'item' => 'required|string',
            'change' => 'required|integer',
        ]);

        $service->recordMovement($data['item'], $data['change']);

        return response()->json(['status' => 'recorded'], 201);
    }

    public function levels(InventoryLevelService $service)
    {
        return response()->json($service->getLevels());
    }
}
