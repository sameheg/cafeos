<?php

namespace Modules\Core\Http\Controllers;

use Modules\Core\Events\ModuleToggled;
use Modules\Core\Models\Tenant;

class ModuleController
{
    public function index()
    {
        $tenant = app('currentTenant');
        $modules = $tenant->modules()->get(['module', 'enabled']);

        return response()->json($modules);
    }

    public function toggle(string $name)
    {
        /** @var Tenant $tenant */
        $tenant = app('currentTenant');
        $registry = $tenant->modules()->firstOrCreate(
            ['module' => $name],
            ['enabled' => false]
        );
        $registry->enabled = ! $registry->enabled;
        $registry->save();

        ModuleToggled::dispatch($tenant, $name, $registry->enabled);

        return response()->json([
            'message' => __('core::messages.module_toggled'),
            'module' => $name,
            'enabled' => $registry->enabled,
        ]);
    }
}
