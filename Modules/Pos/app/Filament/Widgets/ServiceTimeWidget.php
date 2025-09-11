<?php

namespace Modules\Pos\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;
use Modules\Pos\Models\PosOrder;

class ServiceTimeWidget extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        $avg = PosOrder::query()->whereNotNull('paid_at')->avg(DB::raw('TIMESTAMPDIFF(SECOND, created_at, paid_at)'));
        return [
            Card::make('Avg Service Time', $avg ? round($avg) . 's' : 'N/A'),
        ];
    }
}
