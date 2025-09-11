<?php

namespace Modules\Kiosk\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ConversionRateWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Conversion Rate', '85%'),
        ];
    }
}
