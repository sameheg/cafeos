<?php

namespace Modules\FloorPlanDesigner\Filament\Resources;

use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Carbon;
use Modules\FloorPlanDesigner\Models\Floorplan;

class FloorplanResource extends Resource
{
    protected static ?string $model = Floorplan::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('version')->numeric()->default(1)->required(),
            Select::make('state')
                ->options([
                    'draft' => 'Draft',
                    'versioned' => 'Versioned',
                    'archived' => 'Archived',
                ])->required()->native(false),
            DateTimePicker::make('scheduled_at')
                ->seconds(false)
                ->timezone(config('app.timezone'))
                ->helperText('Optional: schedule when this version should become active.'),
            KeyValue::make('json_data')
                ->keyLabel('Key')
                ->valueLabel('Value')
                ->reorderable()
                ->addButtonLabel('Add item')
                ->helperText('Stores the plan JSON (tables/areas/paths). For advanced editing, use the Designer UI.')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->copyable()->toggleable(),
                TextColumn::make('version')->sortable(),
                TextColumn::make('state')->badge(),
                TextColumn::make('scheduled_at')->dateTime()->sortable(),
                TextColumn::make('updated_at')->since()->sortable()->label('Updated'),
            ])
            ->filters([])
            ->actions([
                Action::make('publish')
                    ->visible(fn (Floorplan $record) => $record->state !== 'versioned')
                    ->requiresConfirmation()
                    ->action(fn (Floorplan $record) => $record->publish()),
                Action::make('archive')
                    ->visible(fn (Floorplan $record) => $record->state !== 'archived')
                    ->requiresConfirmation()
                    ->action(fn (Floorplan $record) => $record->archive()),
            ])
            ->bulkActions([
                BulkAction::make('bulkPublish')->action(fn ($records) => $records->each->publish())
            ]);
    }
}
