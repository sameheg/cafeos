<?php

namespace App\Http\Controllers;

use App\Services\ThemeService;
use App\Theme;
use App\StoreSetting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    protected ThemeService $themes;

    public function __construct(ThemeService $themes)
    {
        $this->themes = $themes;
    }

    public function index()
    {
        $themes = $this->themes->listThemes();
        return view('theme.index', compact('themes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
            'logo' => 'nullable|string',
            'font' => 'nullable|string',
            'layout' => 'nullable|string',
        ]);
        $data['user_id'] = $request->user()->id;
        $this->themes->createTheme($data);
        return redirect()->route('themes.index');
    }

    public function destroy(Theme $theme)
    {
        $this->themes->deleteTheme($theme);
        return redirect()->route('themes.index');
    }

    public function assign(Request $request, Theme $theme)
    {
        $this->themes->assignThemeToUser($theme->id, $request->user()->id);
        return redirect()->route('themes.index');
    }

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
