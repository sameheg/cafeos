<?php

namespace Modules\Inventory\Filament;

use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Inventory\Models\InventoryItem;

class InventoryItemResource extends Resource
{
    protected static ?string $model = InventoryItem::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            // fields placeholder
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            // columns placeholder
        ]);
    }
}
