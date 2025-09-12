<?php

namespace Modules\Franchise\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Modules\Franchise\Models\FranchiseBranch;

class FranchiseBranchResource extends Resource
{
    protected static ?string $model = FranchiseBranch::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
        ]);
    }

    public static function getPages(): array
    {
        return [];
    }
}
