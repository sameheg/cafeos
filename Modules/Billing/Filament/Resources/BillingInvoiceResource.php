<?php

namespace Modules\Billing\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Modules\Billing\Models\Invoice;

class BillingInvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('amount'),
            Tables\Columns\TextColumn::make('status'),
        ]);
    }

    public static function getPages(): array
    {
        return [];
    }
}
