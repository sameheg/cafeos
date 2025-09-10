<?php

namespace Modules\SuperAdmin\Http\Controllers;

use App\Models\TenantModule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ModuleController extends Controller
{
    public function index()
    {
        return response()->json(TenantModule::all());
    }

    public function update(Request $request, string $module)
    {
        $tenantModule = TenantModule::where('module', $module)->firstOrFail();
        $tenantModule->update(['enabled' => $request->boolean('enabled')]);

        return response()->json($tenantModule);
    }
}
