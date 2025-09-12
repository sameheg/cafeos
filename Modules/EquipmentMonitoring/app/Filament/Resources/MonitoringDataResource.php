<?php

namespace Modules\EquipmentMonitoring\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Modules\EquipmentMonitoring\Filament\Resources\MonitoringDataResource\Pages;
use Modules\EquipmentMonitoring\Models\MonitoringData;

class MonitoringDataResource extends Resource
{
    protected static ?string $model = MonitoringData::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('tenant_id')->required(),
            Forms\Components\TextInput::make('equipment_id')->required(),
            Forms\Components\TextInput::make('metric')->required(),
            Forms\Components\TextInput::make('value')->numeric()->required(),
            Forms\Components\DateTimePicker::make('timestamp')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('equipment_id'),
            Tables\Columns\TextColumn::make('metric'),
            Tables\Columns\TextColumn::make('value'),
            Tables\Columns\TextColumn::make('timestamp'),
        ])->bulkActions([
            Tables\Actions\BulkAction::make('bulkReset')
                ->action(fn ($records) => MonitoringData::whereKey($records->pluck('id'))->delete())
                ->label('Bulk Reset'),
        ])->headerActions([
            Tables\Actions\ImportAction::make(),
            Tables\Actions\ExportAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMonitoringData::route('/'),
            'create' => Pages\CreateMonitoringData::route('/create'),
            'edit' => Pages\EditMonitoringData::route('/{record}/edit'),
        ];
    }
}
