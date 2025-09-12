<?php

namespace Modules\Marketplace\Filament\Resources;

use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Marketplace\Models\MarketplaceBid;

class MarketplaceBidResource extends Resource
{
    protected static ?string $model = MarketplaceBid::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            // form fields placeholder
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            // table columns placeholder
        ])->bulkActions([
            // bulk award action placeholder
        ]);
    }
}
