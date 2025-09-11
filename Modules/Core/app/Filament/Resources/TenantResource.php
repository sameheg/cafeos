<?php

namespace Modules\Core\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Gate;
use Modules\Core\Models\Tenant;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    public static function canViewAny(): bool
    {
        return Gate::allows('manage-tenants');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('subdomain')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('subdomain'),
        ])
        ->bulkActions([
            Tables\Actions\BulkAction::make('export')
                ->action(fn($records) => null),
        ]);
    }
}
