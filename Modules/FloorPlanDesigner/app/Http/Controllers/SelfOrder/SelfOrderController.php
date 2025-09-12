<?php

namespace Modules\FloorPlanDesigner\Http\Controllers\SelfOrder;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Modules\FloorPlanDesigner\Models\Furniture;

class SelfOrderController
{
    public function show(Request $req): View
    {
        // /qr?tenant=...&plan=...&table=...
        $tenant = $req->query('tenant');
        $plan = $req->query('plan');
        $table = $req->query('table'); // pos_table_id or furniture id
        $f = Furniture::where('plan_id', $plan)
            ->where(function($q) use ($table) { $q->where('pos_table_id', $table)->orWhere('id', $table); })
            ->first();
        abort_unless($f, 404);
        return view('floorplandesigner::selforder', ['table' => $f, 'tenant' => $tenant]);
    }

    public function startOrder(Request $req): JsonResponse
    {
        // stub integration: delegates to POS API in your app
        $data = $req->validate([ 'pos_table_id' => 'required', 'items' => 'array' ]);
        // TODO: call POS start order endpoint
        return response()->json(['ok' => true, 'order_id' => 'stub-order-id']);
    }
}
