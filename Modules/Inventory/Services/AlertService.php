<?php

namespace Modules\Inventory\Services;

use App\Models\InventoryAlert;
use App\Notifications\InventoryAlertNotification;
use App\Product;
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
            $this->recordAlert($product, 'stock', $message);

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
            $this->recordAlert($product, 'sales', $message);

            Notification::route('mail', config('mail.from.address'))
                ->notify(new InventoryAlertNotification($product, $message));
        }
    }

    /**
     * Persist alert information to the database.
     */
    protected function recordAlert(Product $product, string $type, string $message): void
    {
        InventoryAlert::create([
            'product_id' => $product->id,
            'business_id' => $product->business_id,
            'type' => $type,
            'message' => $message,
        ]);
    }
}
