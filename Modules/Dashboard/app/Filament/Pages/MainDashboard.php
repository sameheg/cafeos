<?php

namespace Modules\Dashboard\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Modules\Dashboard\Filament\Widgets\KpiChart;
use Modules\Dashboard\Filament\Widgets\HeatmapWidget;

class MainDashboard extends BaseDashboard
{
    protected function getWidgets(): array
    {
        return [
            KpiChart::class,
            HeatmapWidget::class,
        ];
    }
}
