<?php

namespace Modules\Notifications\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Modules\Notifications\Models\NotificationLog;

class LatencyWidget extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        $avg = NotificationLog::whereNotNull('sent_at')
            ->avg(\DB::raw('TIMESTAMPDIFF(SECOND, created_at, sent_at)'));

        return [
            Card::make('Avg Latency (s)', round($avg ?? 0, 2)),
        ];
    }
}
