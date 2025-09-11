<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Core\Models\ModuleRegistry;
use Modules\Core\Models\Tenant;

class MetricsController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'tenants' => Tenant::count(),
            'modules' => ModuleRegistry::withoutGlobalScopes()->count(),
        ]);
    }
}
