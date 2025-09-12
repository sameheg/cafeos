<?php

namespace Modules\FloorPlanDesigner\Filament\Resources\FloorplanResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class ZonesRelationManager extends RelationManager
{
    protected static string $relationship = 'zones';
    protected static ?string $recordTitleAttribute = 'name';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            KeyValue::make('coords')
                ->keyLabel('Key')
                ->valueLabel('Value')
                ->helperText('Expected array of points: [{x,y}, ...]')
                ->addButtonLabel('Add point')
                ->required(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('id')->copyable()->toggleable(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('created_at')->since(),
        ])->headerActions([
            Tables\Actions\CreateAction::make(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }
}
