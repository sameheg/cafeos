<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Modules\Core\Models\Tenant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Users', User::count()),
            Card::make('Tenants', Tenant::count()),
        ];
    }
}
