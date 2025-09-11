<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Models\Setting;

class SettingsController
{
    public function index()
    {
        $settings = Setting::query()
            ->get()
            ->mapWithKeys(fn ($s) => ["{$s->group}.{$s->key}" => $s->value]);

        return response()->json($settings);
    }

    public function update(Request $request)
    {
        foreach ($request->input('settings', []) as $compound => $value) {
            [$group, $key] = explode('.', $compound, 2);
            Setting::updateOrCreate([
                'group' => $group,
                'key' => $key,
            ], [
                'value' => $value,
            ]);
        }

        return response()->noContent();
    }
}
