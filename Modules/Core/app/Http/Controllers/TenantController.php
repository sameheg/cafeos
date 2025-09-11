<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Modules\Core\Events\TenantCreated;
use Modules\Core\Http\Requests\TenantRequest;
use Modules\Core\Http\Resources\TenantResource;
use Modules\Core\Models\Tenant;

class TenantController
{
    public function index()
    {
        Gate::authorize('viewAny', Tenant::class);

        return TenantResource::collection(Tenant::all());
    }

    public function store(TenantRequest $request)
    {
        Gate::authorize('create', Tenant::class);

        $tenant = Tenant::create($request->validated());
        TenantCreated::dispatch($tenant);

        return (new TenantResource($tenant))->additional([
            'message' => __('core::messages.tenant_created'),
        ]);
    }
}
