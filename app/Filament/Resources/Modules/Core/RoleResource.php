<?php

namespace App\Filament\Resources\Modules\Core;

use App\Filament\Resources\Concerns\TenantScoped;
use App\Filament\Resources\Modules\Core\Pages\CreateRole;
use App\Filament\Resources\Modules\Core\Pages\EditRole;
use App\Filament\Resources\Modules\Core\Pages\ListRoles;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Core\Models\Role;

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
                TextColumn::make('name'),
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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
