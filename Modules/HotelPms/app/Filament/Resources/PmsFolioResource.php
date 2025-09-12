<?php

namespace Modules\HotelPms\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Gate;
use Modules\HotelPms\Models\Folio;
use Modules\HotelPms\Filament\Resources\PmsFolioResource\Pages;

class PmsFolioResource extends Resource
{
    protected static ?string $model = Folio::class;

    public static function canViewAny(): bool
    {
        return Gate::allows('post_folio');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('guest_id')->required(),
            Forms\Components\TextInput::make('total')->required(),
            Forms\Components\Select::make('status')->options([
                Folio::STATUS_OPEN => 'Open',
                Folio::STATUS_POSTED => 'Posted',
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('guest_id'),
            Tables\Columns\TextColumn::make('total'),
            Tables\Columns\TextColumn::make('status'),
        ])->bulkActions([
            Tables\Actions\BulkAction::make('bulkSync')
                ->label('Bulk Sync')
                ->action(fn ($records) => null),
            Tables\Actions\BulkAction::make('exportCsv')
                ->label('Export CSV')
                ->action(fn ($records) => null),
            Tables\Actions\BulkAction::make('importCsv')
                ->label('Import CSV')
                ->action(fn ($records) => null),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPmsFolios::route('/'),
            'edit' => Pages\EditPmsFolio::route('/{record}/edit'),
        ];
    }
}
