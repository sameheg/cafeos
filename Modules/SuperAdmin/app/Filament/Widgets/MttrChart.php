<?php

namespace Modules\SuperAdmin\Filament\Widgets;

use Filament\Widgets\Widget;

class MttrChart extends Widget
{
    protected static string $view = 'superadmin::widgets.mttr-chart';

    protected function getViewData(): array
    {
        return ['mttr' => 5];
    }
}
