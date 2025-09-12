<?php

namespace Modules\ArMenu\Filament\Pages;

use Filament\Pages\Page;
use Modules\ArMenu\Filament\Widgets\ViewToAddChart;
use Modules\ArMenu\Filament\Widgets\LoadTimeWidget;

class ArConversion extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'ar-menu::filament.pages.conversion';

    protected function getHeaderWidgets(): array
    {
        return [
            ViewToAddChart::class,
            LoadTimeWidget::class,
        ];
    }
}
