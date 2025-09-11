<?php

namespace Modules\Core\Infrastructure\Providers;

use Filament\Panel;
use Filament\PanelProvider;

class CorePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel->id('core')->path('admin');
    }
}
