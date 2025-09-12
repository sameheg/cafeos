<?php

namespace Modules\HotelPms\Filament\Pages;

use Filament\Pages\Page;
use Modules\HotelPms\Filament\Widgets\AccuracyChart;
use Modules\HotelPms\Filament\Widgets\CrossSellWidget;

class PmsCrosssell extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'hotelpms::pages.crosssell';

    protected function getWidgets(): array
    {
        return [
            AccuracyChart::class,
            CrossSellWidget::class,
        ];
    }
}
