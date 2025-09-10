<?php

namespace App\Filament\Resources\Modules\Pos\MenuItems;

use App\Filament\Resources\Concerns\TenantScoped;
use App\Filament\Resources\Modules\Pos\MenuItems\Pages\CreateMenuItem;
use App\Filament\Resources\Modules\Pos\MenuItems\Pages\EditMenuItem;
use App\Filament\Resources\Modules\Pos\MenuItems\Pages\ListMenuItems;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Pos\Models\MenuItem;

class MenuItemResource extends Resource
{
    use TenantScoped;

    /** @var class-string<\Modules\Pos\Models\MenuItem> */
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
                TextColumn::make('name'),
                TextColumn::make('formatted_price')->label('Price'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
