<?php

namespace Modules\ArMenu\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\ArMenu\Models\ArAsset;
use Modules\ArMenu\Filament\Resources\ArAssetResource\Pages;

class ArAssetResource extends Resource
{
    protected static ?string $model = ArAsset::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('item_id')->required(),
            Forms\Components\TextInput::make('url')->required(),
            Forms\Components\Select::make('type')->options([
                'ar' => 'AR',
                'vr' => 'VR',
            ])->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('item_id'),
            Tables\Columns\TextColumn::make('type'),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArAssets::route('/'),
            'create' => Pages\CreateArAsset::route('/create'),
            'edit' => Pages\EditArAsset::route('/{record}/edit'),
        ];
    }
}
