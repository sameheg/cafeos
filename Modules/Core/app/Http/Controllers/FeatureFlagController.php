<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Models\FeatureFlag;

class FeatureFlagController
{
    public function index(Request $request)
    {
        $tenant = app('currentTenant');

        return FeatureFlag::query()->where('tenant_id', $tenant->id)->get();
    }

    public function update(Request $request, string $key)
    {
        $tenant = app('currentTenant');
        $flag = FeatureFlag::updateOrCreate(
            ['tenant_id' => $tenant->id, 'key' => $key],
            ['value' => (bool) $request->boolean('value')]
        );

        return response()->json($flag);
    }
}
