<?php

namespace Modules\Core\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TenantSwitchController
{
    /**
     * Switch the current tenant context.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $tenant = Tenant::findOrFail($request->input('tenant_id'));
        tenancy()->initialize($tenant);
        session()->put('tenant_id', $tenant->id);

        return redirect()->back();
    }
}
