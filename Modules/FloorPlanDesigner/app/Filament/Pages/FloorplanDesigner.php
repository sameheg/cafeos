<?php

namespace Modules\FloorPlanDesigner\Filament\Pages;

use Filament\Pages\Page;

class FloorplanDesigner extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Designer';
    protected static ?string $slug = 'floorplan-designer';
    protected static string $view = 'floorplandesigner::designer_pro';
}
