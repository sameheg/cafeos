<?php

namespace Modules\Pos\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms;
use Filament\Tables;
use Modules\Pos\Models\PosCustomer;

class PosCustomerResource extends Resource
{
    protected static ?string $model = PosCustomer::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('phone'),
            Forms\Components\TextInput::make('email')->email(),
            Forms\Components\KeyValue::make('meta'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('phone'),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('created_at')->since(),
        ]);
    }
}
