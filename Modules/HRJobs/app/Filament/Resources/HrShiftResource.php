<?php

namespace Modules\HRJobs\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables;
use Modules\HRJobs\Models\Shift;

class HrShiftResource extends Resource
{
    protected static ?string $model = Shift::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('employee_id')->required(),
            Forms\Components\DateTimePicker::make('start')->required(),
            Forms\Components\DateTimePicker::make('end')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_id'),
                Tables\Columns\TextColumn::make('start'),
                Tables\Columns\TextColumn::make('end'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('assign')->action(fn () => null),
            ]);
    }
}

