<?php

namespace Modules\Notifications\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Modules\Notifications\Models\NotificationLog;

class NotificationLogResource extends Resource
{
    protected static ?string $model = NotificationLog::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('channel'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('sent_at')->dateTime(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('retry')
                    ->action(fn ($records) => $records->each(fn ($log) => $log->update(['status' => 'queued'])))
                    ->requiresConfirmation(),
            ]);
    }
}
