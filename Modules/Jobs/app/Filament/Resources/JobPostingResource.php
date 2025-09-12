<?php

namespace Modules\Jobs\Filament\Resources;

use Modules\Jobs\Models\JobPosting;

if (class_exists(\Filament\Resources\Resource::class)) {
    class JobPostingResource extends \Filament\Resources\Resource
    {
        protected static ?string $model = JobPosting::class;

        public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
        {
            return $form->schema([
                \Filament\Forms\Components\TextInput::make('title')->required(),
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        JobPosting::STATUS_OPEN => 'Open',
                        JobPosting::STATUS_CLOSED => 'Closed',
                    ])->required(),
            ]);
        }

        public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
        {
            return $table->columns([
                \Filament\Tables\Columns\TextColumn::make('title'),
                \Filament\Tables\Columns\TextColumn::make('status'),
            ]);
        }

        public static function getPages(): array
        {
            return [
                'index' => \Filament\Resources\Pages\ListRecords::route('/'),
            ];
        }
    }
}
