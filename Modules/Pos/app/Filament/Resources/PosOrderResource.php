<?php

namespace Modules\Pos\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Gate;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Filament\Resources\PosOrderResource\Pages;

class PosOrderResource extends Resource
{
    protected static ?string $model = PosOrder::class;

    public static function canViewAny(): bool
    {
        return Gate::allows('view_pos_orders');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('status')->required(),
            Forms\Components\TextInput::make('total')->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('total'),
        ])->bulkActions([
            Tables\Actions\BulkAction::make('bulkRefund')
                ->action(fn($records) => null)
                ->requiresConfirmation(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosOrders::route('/'),
            'edit' => Pages\EditPosOrder::route('/{record}/edit'),
        ];
    }
}
