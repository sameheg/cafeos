<?php

namespace Modules\Kiosk\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Modules\Kiosk\Filament\Resources\KioskResource\Pages;
use Modules\Kiosk\Models\Kiosk;

class KioskResource extends Resource
{
    protected static ?string $model = Kiosk::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('location')->required(),
            Forms\Components\Select::make('status')->options([
                'active' => 'Active',
                'idle' => 'Idle',
            ])->required(),
            Forms\Components\TextInput::make('max_queue')->numeric()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('location'),
            Tables\Columns\TextColumn::make('status'),
            Tables\Columns\TextColumn::make('max_queue'),
        ])->bulkActions([
            Tables\Actions\BulkAction::make('bulkReset')
                ->action(fn($records) => null)
                ->label('Bulk Reset'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKiosks::route('/'),
            'create' => Pages\CreateKiosk::route('/create'),
            'edit' => Pages\EditKiosk::route('/{record}/edit'),
        ];
    }
}
