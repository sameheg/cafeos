<?php

namespace Modules\FloorPlanDesigner\Filament\Resources;

use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Modules\FloorPlanDesigner\Models\Floorplan;

class FloorplanResource extends Resource
{
    protected static ?string $model = Floorplan::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('tenant_id')->required(),
            Forms\Components\Textarea::make('json_data')->required()->columnSpanFull(),
            Forms\Components\TextInput::make('version')->numeric()->default(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->label('ID'),
            Tables\Columns\TextColumn::make('version'),
            Tables\Columns\TextColumn::make('state'),
        ])->bulkActions([
            Tables\Actions\BulkAction::make('bulkPublish')->action(fn ($records) => $records->each->publish()),
        ]);
    }
}
