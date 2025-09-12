<?php

namespace Modules\FoodSafety\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Modules\FoodSafety\Models\FoodSafetyLog;

class ComplianceRateWidget extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        $total = FoodSafetyLog::count();
        $breaches = FoodSafetyLog::where('status', 'alerted')->count();
        $rate = $total > 0 ? (1 - $breaches / max($total, 1)) * 100 : 100;

        return [
            Card::make('Compliance Rate', number_format($rate, 2) . '%'),
        ];
    }
}
