<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreSetting;

class ThemeController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'theme' => 'required|string',
        ]);

        $user = $request->user();
        if ($user) {
            StoreSetting::updateOrCreate(
                ['business_id' => $user->business_id],
                ['theme' => $request->input('theme')]
            );
        }

        return response()->json(['status' => 'success']);
    }
}
