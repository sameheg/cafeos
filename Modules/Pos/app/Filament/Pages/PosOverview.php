<?php

namespace Modules\Pos\Filament\Pages;

use Filament\Pages\Page;
use Modules\Pos\Filament\Widgets\DailySalesChart;
use Modules\Pos\Filament\Widgets\ServiceTimeWidget;

class PosOverview extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'pos::overview';

    protected function getWidgets(): array
    {
        return [DailySalesChart::class, ServiceTimeWidget::class];
    }
}
