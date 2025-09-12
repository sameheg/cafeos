<?php

namespace Modules\Pos\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Modules\Pos\Models\PosBill;

class PosBillResource extends Resource
{
    protected static ?string $model = PosBill::class;
    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('order_id')->label('Order'),
            Tables\Columns\TextColumn::make('label'),
            Tables\Columns\TextColumn::make('total')->money('egp', true),
            Tables\Columns\TextColumn::make('outstanding_total')->money('egp', true),
            Tables\Columns\TextColumn::make('created_at')->since(),
        ]);
    }
}
