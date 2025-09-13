<?php

namespace App\Filament\Dashboard\Resources\Transactions;

use App\Constants\TransactionStatus;
use App\Filament\Dashboard\Resources\Orders\Pages\ViewOrder;
use App\Filament\Dashboard\Resources\Subscriptions\Pages\ViewSubscription;
use App\Filament\Dashboard\Resources\Transactions\Pages\ListTransactions;
use App\Mapper\TransactionStatusMapper;
use App\Models\Transaction;
use App\Services\AddressService;
use App\Services\ConfigService;
use App\Services\InvoiceService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')
                    ->label(__('Amount'))
                    ->formatStateUsing(function (string $state, $record) {
                        return money($state, $record->currency->code);
                    }),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->color(fn (Transaction $record, TransactionStatusMapper $mapper): string => $mapper->mapColor($record->status))
                    ->badge()
                    ->formatStateUsing(fn (string $state, TransactionStatusMapper $mapper): string => $mapper->mapForDisplay($state)),
                TextColumn::make('owner')
                    ->label(__('Owner'))
                    ->getStateUsing(fn (Transaction $record) => $record->subscription_id !== null ? ($record->subscription->plan?->name ?? '-') : ($record->order_id !== null ? __('View Order') : '-'))
                    ->url(function (Transaction $record) {
                        if ($record->subscription_id && Route::has('filament.dashboard.resources.subscriptions.view')) {
                            return ViewSubscription::getUrl(['record' => $record->subscription]);
                        }

                        if ($record->order_id !== null && Route::has('filament.dashboard.resources.orders.view')) {
                            return ViewOrder::getUrl(['record' => $record->order]);
                        }
                    }),
                TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('see-invoice')
                    ->label(__('See Invoice'))
                    ->icon('heroicon-o-document')
                    ->visible(fn (Transaction $record, InvoiceService $invoiceService): bool => $invoiceService->canGenerateInvoices($record))
                    ->modalDescription(function (AddressService $addressService) {
                        if (! $addressService->userHasAddressInfo(auth()->user())) {
                            return __('Your address information is not complete. It is recommended to complete your address information before generating an invoice. Are you sure you want to proceed?');
                        }

                        return null;
                    })
                    ->modalCancelAction(
                        Action::make('complete-address-information')
                            ->label(__('Complete Address Info'))
                            ->url(route('filament.dashboard.pages.my-profile', ['tenant' => Filament::getTenant()]))
                    )
                    ->modalSubmitActionLabel(__('Proceed anyway'))
                    ->action(function (Transaction $record) {
                        return redirect()->route('invoice.generate', ['transactionUuid' => $record->uuid]);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([

                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransactions::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canUpdate(Model $record): bool
    {
        return false;
    }

    public static function canUpdateAny(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('tenant_id', Filament::getTenant()->id)->where('amount', '>', 0)->where('status', '!=', TransactionStatus::NOT_STARTED->value);
    }

    public static function getModelLabel(): string
    {
        return __('Payments');
    }

    public static function isDiscovered(): bool
    {
        return app()->make(ConfigService::class)->get('app.customer_dashboard.show_transactions', true);
    }
}
