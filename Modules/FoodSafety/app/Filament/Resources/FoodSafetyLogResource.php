<?php

namespace Modules\FoodSafety\Filament\Resources;

use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Modules\FoodSafety\Models\FoodSafetyLog;

class FoodSafetyLogResource extends Resource
{
    protected static ?string $model = FoodSafetyLog::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('item_id')->required(),
            Forms\Components\TextInput::make('temp')->numeric()->required(),
            Forms\Components\TextInput::make('status')->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('item_id'),
            Tables\Columns\TextColumn::make('temp'),
            Tables\Columns\TextColumn::make('status'),
        ])->bulkActions([
            Tables\Actions\BulkAction::make('bulkVerify')->action(fn () => null),
        ]);
    }
}
