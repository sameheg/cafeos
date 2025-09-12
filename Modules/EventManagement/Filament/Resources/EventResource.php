<?php

namespace Modules\EventManagement\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Forms;
use Filament\Resources\Table;
use Filament\Tables;
use Modules\EventManagement\Models\Event;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('capacity')->numeric()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('capacity'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => EventResource\Pages\ListEvents::class,
            'create' => EventResource\Pages\CreateEvent::class,
            'edit' => EventResource\Pages\EditEvent::class,
        ];
    }
}
