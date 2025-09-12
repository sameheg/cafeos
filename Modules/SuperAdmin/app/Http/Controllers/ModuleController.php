<?php

namespace Modules\SuperAdmin\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\SuperAdmin\Http\Requests\ModuleToggleRequest;
use Modules\SuperAdmin\Models\Flag;

class ModuleController extends Controller
{
    public function update(ModuleToggleRequest $request)
    {
        Flag::updateOrCreate(
            ['module' => $request->module, 'tenant_id' => $request->tenant_id],
            ['enabled' => $request->boolean('enabled')]
        );

        return response()->json(['updated' => true]);
    }
}
