<?php

namespace Modules\Kiosk\Filament\Pages;

use Filament\Pages\Page;

class KioskPerformance extends Page
{
    protected static string $view = 'kiosk::performance';

    protected function getHeaderWidgets(): array
    {
        return [
            \Modules\Kiosk\Filament\Widgets\OrdersPerDayChart::class,
            \Modules\Kiosk\Filament\Widgets\ConversionRateWidget::class,
        ];
    }
}
