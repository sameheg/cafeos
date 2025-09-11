<?php

namespace Modules\Core\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FeatureFlagController extends Controller
{
    public function index(Request $request)
    {
        $tenant = app('currentTenant');

        return $tenant->flags->map(fn ($flag) => [
            'key' => $flag->name,
            'value' => true,
        ]);
    }

    public function update(Request $request, string $key)
    {
        $tenant = app('currentTenant');
        if ($request->boolean('value')) {
            $tenant->flag($key);
        } else {
            $tenant->unflag($key);
        }

        return response()->json([
            'key' => $key,
            'value' => $tenant->hasFlag($key),
        ]);
    }
}
