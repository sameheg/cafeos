<?php

namespace Modules\Inventory\Services;

use App\Notifications\InventoryAlertNotification;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AlertService
{
    /**
     * Check stock level of a product and trigger alert if below threshold.
     */
    public function checkProductStock(Product $product): void
    {
        if (!is_null($product->alert_quantity) && $product->quantity_available <= $product->alert_quantity) {
            $message = "Stock for {$product->name} is below threshold.";
            $this->recordAlert($product->id, 'stock', $message);

            Notification::route('mail', config('mail.from.address'))
                ->notify(new InventoryAlertNotification($product, $message));
        }
    }

    /**
     * Check sales volume of a product and trigger alert if exceeds threshold.
     */
    public function checkProductSales(Product $product, int $soldQuantity): void
    {
        if (!is_null($product->alert_sales_quantity) && $soldQuantity >= $product->alert_sales_quantity) {
            $message = "{$product->name} sales exceeded {$product->alert_sales_quantity}.";
            $this->recordAlert($product->id, 'sales', $message);

            Notification::route('mail', config('mail.from.address'))
                ->notify(new InventoryAlertNotification($product, $message));
        }
    }

    /**
     * Persist alert information to the database.
     */
    protected function recordAlert(int $productId, string $type, string $message): void
    {
        DB::table('inventory_alerts')->insert([
            'product_id' => $productId,
            'type' => $type,
            'message' => $message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
