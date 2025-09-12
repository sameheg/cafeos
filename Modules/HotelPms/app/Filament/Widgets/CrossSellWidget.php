<?php

namespace Modules\HotelPms\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CrossSellWidget extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Cross-sell', '0%'),
        ];
    }
}
