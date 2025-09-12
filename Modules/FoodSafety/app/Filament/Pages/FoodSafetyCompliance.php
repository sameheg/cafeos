<?php

namespace Modules\FoodSafety\Filament\Pages;

use Filament\Pages\Dashboard;
use Modules\FoodSafety\Filament\Widgets\ComplianceRateWidget;
use Modules\FoodSafety\Filament\Widgets\IncidentChart;

class FoodSafetyCompliance extends Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected function getWidgets(): array
    {
        return [
            IncidentChart::class,
            ComplianceRateWidget::class,
        ];
    }
}
