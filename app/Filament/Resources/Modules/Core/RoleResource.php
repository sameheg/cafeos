<?php

namespace App\Filament\Resources\Modules\Core;

use App\Filament\Resources\Concerns\TenantScoped;
use App\Filament\Resources\Modules\Core\Pages\CreateRole;
use App\Filament\Resources\Modules\Core\Pages\EditRole;
use App\Filament\Resources\Modules\Core\Pages\ListRoles;
use Modules\Core\Models\Role;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    use TenantScoped;

    protected static ?string $model = Role::class;

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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
