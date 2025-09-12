<?php
namespace Modules\Pos\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Pos\App\Contracts\BillingGateway;
use Modules\Pos\App\Contracts\InventoryGateway;

class PosServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BillingGateway::class, function () {
            return new class implements BillingGateway {
                public function createInvoice($order, array $lines, array $meta = []): array {
                    return ['invoice_id' => 'INV-'.($order->id ?? 'X'), 'number' => date('Y').'-'.str_pad((string)($order->id ?? 1), 4, '0', STR_PAD_LEFT), 'total' => $order->total ?? 0];
                }
            };
        });

        $this->app->bind(InventoryGateway::class, function () {
            return new class implements InventoryGateway {
                public function consumeItems(array $items, array $meta = []): bool { return true; }
            };
        });
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        $this->mergeConfigFrom(__DIR__.'/../../config/pos.php', 'pos');
    }
}
