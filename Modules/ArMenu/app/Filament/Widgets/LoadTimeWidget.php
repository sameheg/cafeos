<?php

namespace Modules\ArMenu\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class LoadTimeWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Avg Load Time', '1.2s'),
        ];
    }
}
