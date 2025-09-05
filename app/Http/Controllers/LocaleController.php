<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request)
    {
        $locale = $request->input('locale');

        if (array_key_exists($locale, config('constants.langs'))) {
            $request->session()->put('user.language', $locale);
            app()->setLocale($locale);
        }

        return response()->json(['success' => true]);
    }
}

