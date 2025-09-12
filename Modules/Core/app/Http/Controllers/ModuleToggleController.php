<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Core\Events\JsonDomainEvent;
use Modules\Core\Models\FeatureFlag;
use Symfony\Component\HttpFoundation\Response;

class ModuleToggleController extends Controller
{
    public function update(Request $request, string $module): Response
    {
        $validated = $request->validate([
            'enabled' => ['required', 'boolean'],
        ]);

        $tenantId = app()->bound('tenant') ? app('tenant')->id : $request->user()?->tenant_id;

        FeatureFlag::updateOrCreate(
            ['tenant_id' => $tenantId, 'name' => $module],
            ['enabled' => $request->boolean('enabled')]
        );

        event(new JsonDomainEvent(
            'admin.module.toggled@v1',
            ['module' => $module, 'enabled' => $request->boolean('enabled')],
            (string) Str::ulid()
        ));

        return response()->json(['updated' => true]);
    }
}
