<?php

namespace Modules\FloorPlanDesigner\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\FloorPlanDesigner\Events\FloorLayoutUpdated;
use Modules\FloorPlanDesigner\Models\FloorLayout;

class FloorPlanController extends Controller
{
    public function index()
    {
        $layout = FloorLayout::first();
        return view('floor-plan-designer::editor', ['layout' => $layout?->layout ?? []]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'layout' => 'required|json',
        ]);

        $layout = FloorLayout::updateOrCreate(
            ['tenant_id' => app('tenant')->id],
            ['layout' => $data['layout']]
        );

        event(new FloorLayoutUpdated($layout));

        return response()->json(['status' => 'ok']);
    }
}

