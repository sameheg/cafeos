<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Core\Models\Tenant;
use Symfony\Component\HttpFoundation\Response;

class TenantController extends Controller
{
    public function store(Request $request): Response
    {
        $data = $request->validate([
            'name' => 'required|string',
            'subdomain' => 'required|regex:/^[a-z0-9-]+$/i|unique:tenants,subdomain',
        ]);

        $tenant = Tenant::create($data);

        return response(['tenant_id' => $tenant->id], 201);
    }
}
