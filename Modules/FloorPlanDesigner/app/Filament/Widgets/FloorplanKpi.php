<?php

namespace Modules\FloorPlanDesigner\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class FloorplanKpi extends BaseWidget
{
    protected function getCards(): array
    {
        // Placeholder static values; wire to stats table in production
        return [
            Card::make('Tables', '—'),
            Card::make('Occupied', '—'),
            Card::make('Revenue (Today)', '—'),
        ];
    }
}
