<?php

namespace App\Filament\Resources\Modules\Marketplace;

use App\Filament\Resources\Concerns\TenantScoped;
use App\Filament\Resources\Modules\Marketplace\Pages\CreateListing;
use App\Filament\Resources\Modules\Marketplace\Pages\EditListing;
use App\Filament\Resources\Modules\Marketplace\Pages\ListListings;
use Modules\Marketplace\Models\Listing;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class ListingResource extends Resource
{
    use TenantScoped;

    protected static ?string $model = Listing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('description')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description'),
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
            'index' => ListListings::route('/'),
            'create' => CreateListing::route('/create'),
            'edit' => EditListing::route('/{record}/edit'),
        ];
    }
}
