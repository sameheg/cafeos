<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Concerns\HasWidgets;

class Dashboard extends BaseDashboard
{
    use HasWidgets;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverview::class,
            \App\Filament\Widgets\TenantStats::class,
        ];
    }
}
