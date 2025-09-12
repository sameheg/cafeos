<?php

namespace Modules\SuperAdmin\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Modules\Core\Models\Tenant;
use Modules\SuperAdmin\Filament\Resources\FlagResource\Pages;
use Modules\SuperAdmin\Models\Flag;

class FlagResource extends Resource
{
    protected static ?string $model = Flag::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationGroup = 'Super Admin';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('module')
                ->required(),
            Forms\Components\Select::make('tenant_id')
                ->label('Tenant')
                ->options(fn () => Tenant::pluck('name', 'id'))
                ->searchable()
                ->nullable(),
            Forms\Components\Toggle::make('enabled'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('module')->searchable(),
                Tables\Columns\TextColumn::make('tenant.name')->label('Tenant'),
                Tables\Columns\IconColumn::make('enabled')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFlags::route('/'),
        ];
    }
}

