<?php

namespace Modules\SuperAdmin\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Collection;
use Modules\SuperAdmin\Models\Flag;

class ModuleFlagResource extends Resource
{
    protected static ?string $model = Flag::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('module')->required(),
            TextInput::make('tenant_id'),
            Toggle::make('enabled'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('module'),
                TextColumn::make('tenant_id'),
                IconColumn::make('enabled')->boolean(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('disable')
                    ->action(fn (Collection $records) => $records->each->suspend()),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageModuleFlags::route('/'),
        ];
    }
}
