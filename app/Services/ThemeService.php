<?php

namespace App\Services;

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
}
