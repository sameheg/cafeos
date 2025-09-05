<?php

namespace App\Services;

use App\Theme;
use Illuminate\Support\Arr;

class ThemeService
{
    protected array $themeColors = [
        'primary' => 'Blue',
        'purple' => 'Purple',
        'green' => 'Green',
        'red' => 'Red',
        'yellow' => 'Yellow',
        'orange' => 'Orange',
        'sky' => 'Sky',
    ];

    public function getThemeColors(): array
    {
        return $this->themeColors;
    }

    public function listThemes()
    {
        return Theme::all();
    }

    public function getTheme(int $id): ?Theme
    {
        return Theme::find($id);
    }

    public function getUserTheme(int $userId): ?Theme
    {
        return Theme::where('user_id', $userId)->first();
    }

    public function createTheme(array $data): Theme
    {
        $payload = Arr::only($data, ['user_id', 'name', 'primary_color', 'secondary_color', 'layout']);
        return Theme::create($payload);
    }

    public function updateTheme(Theme $theme, array $data): Theme
    {
        $payload = Arr::only($data, ['name', 'primary_color', 'secondary_color', 'layout']);
        $theme->update($payload);
        return $theme;
    }

    public function deleteTheme(Theme $theme): void
    {
        $theme->delete();
    }
}

