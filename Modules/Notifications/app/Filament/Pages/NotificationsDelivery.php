<?php

namespace Modules\Notifications\Filament\Pages;

use Filament\Pages\Page;
use Modules\Notifications\Filament\Widgets\DeliveryRateChart;
use Modules\Notifications\Filament\Widgets\LatencyWidget;

class NotificationsDelivery extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'notifications::filament.pages.notifications-delivery';

    protected function getHeaderWidgets(): array
    {
        return [
            DeliveryRateChart::class,
            LatencyWidget::class,
        ];
    }
}
