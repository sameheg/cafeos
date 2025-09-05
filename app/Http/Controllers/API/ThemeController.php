<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ThemeService;
use App\Theme;
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
        return $this->themes->listThemes();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'name' => 'nullable|string',
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
            'logo' => 'nullable|string',
            'font' => 'nullable|string',
            'layout' => 'nullable|string',
        ]);
        $theme = $this->themes->saveUserTheme($data['user_id'], $data);
        return response()->json($theme, 201);
    }

    public function show(Theme $theme)
    {
        return $theme;
    }

    public function update(Request $request, Theme $theme)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
            'logo' => 'nullable|string',
            'font' => 'nullable|string',
            'layout' => 'nullable|string',
        ]);
        $theme = $this->themes->updateTheme($theme, $data);
        return response()->json($theme);
    }

    public function destroy(Theme $theme)
    {
        $this->themes->deleteTheme($theme);
        return response()->noContent();
    }
}

