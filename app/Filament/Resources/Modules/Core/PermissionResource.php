<?php

namespace App\Filament\Resources\Modules\Core;

use App\Filament\Resources\Concerns\TenantScoped;
use App\Filament\Resources\Modules\Core\Pages\CreatePermission;
use App\Filament\Resources\Modules\Core\Pages\EditPermission;
use App\Filament\Resources\Modules\Core\Pages\ListPermissions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Core\Models\Permission;

class PermissionResource extends Resource
{
    use TenantScoped;

    protected static ?string $model = Permission::class;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
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
            'index' => ListPermissions::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit' => EditPermission::route('/{record}/edit'),
        ];
    }
}
