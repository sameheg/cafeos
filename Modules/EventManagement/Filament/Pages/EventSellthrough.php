<?php

namespace Modules\EventManagement\Filament\Pages;

use Filament\Pages\Page;
use Modules\EventManagement\Filament\Widgets\NpsChart;
use Modules\EventManagement\Filament\Widgets\SellThroughWidget;

class EventSellthrough extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'event-management::pages.sellthrough';

    protected function getHeaderWidgets(): array
    {
        return [
            NpsChart::class,
            SellThroughWidget::class,
        ];
    }
}
