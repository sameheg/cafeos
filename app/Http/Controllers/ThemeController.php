<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'theme' => 'required|string',
        ]);

        $user = $request->user();
        if ($user) {
            $settings = $user->settings ?? [];
            $settings['theme'] = $request->input('theme');
            $user->settings = $settings;
            $user->save();
        }

        return response()->json(['status' => 'success']);
    }
}
