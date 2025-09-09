<?php

namespace App\Filament\Resources\Modules\Pos\MenuItems;

use App\Filament\Resources\Concerns\TenantScoped;
use App\Filament\Resources\Modules\Pos\MenuItems\Pages\CreateMenuItem;
use App\Filament\Resources\Modules\Pos\MenuItems\Pages\EditMenuItem;
use App\Filament\Resources\Modules\Pos\MenuItems\Pages\ListMenuItems;
use App\Models\Modules\Pos\MenuItem;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    use TenantScoped;

    protected static ?string $model = MenuItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('price')->numeric()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('formatted_price')->label('Price'),
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
            'index' => ListMenuItems::route('/'),
            'create' => CreateMenuItem::route('/create'),
            'edit' => EditMenuItem::route('/{record}/edit'),
        ];
    }
}
