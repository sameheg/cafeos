<?php

namespace App\Filament\Resources\Modules\Pos\Orders;

use App\Filament\Resources\Concerns\TenantScoped;
use App\Filament\Resources\Modules\Pos\Orders\Pages\CreateOrder;
use App\Filament\Resources\Modules\Pos\Orders\Pages\EditOrder;
use App\Filament\Resources\Modules\Pos\Orders\Pages\ListOrders;
use App\Filament\Resources\Modules\Pos\Orders\Schemas\OrderForm;
use App\Filament\Resources\Modules\Pos\Orders\Tables\OrdersTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Pos\Models\Order;

class OrderResource extends Resource
{
    use TenantScoped;

    /** @var class-string<\Modules\Pos\Models\Order> */
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
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
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
