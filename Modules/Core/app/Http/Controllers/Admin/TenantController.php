<?php

namespace Modules\Core\Http\Controllers\Admin;

use App\Models\Tenant;
use Illuminate\Contracts\View\View;

class TenantController
{
    /**
     * Display a listing of tenants.
     */
    public function index(): View
    {
        $tenants = Tenant::all();

        return view('core::admin.tenants.index', compact('tenants'));
    }
}
