<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Events\TenantCreated;
use Modules\Core\Models\Tenant;

class TenantController
{
    public function index()
    {
        return Tenant::all();
    }

    public function store(Request $request)
    {
        $tenant = Tenant::create($request->only('name', 'slug'));
        TenantCreated::dispatch($tenant);

        return response()->json([
            'message' => __('core::messages.tenant_created'),
            'tenant' => $tenant,
        ], 201);
    }
}
