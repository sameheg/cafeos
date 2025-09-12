<?php

namespace Modules\HRJobs\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class TimeToHireWidget extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Time to hire', '21 days'),
        ];
    }
}

