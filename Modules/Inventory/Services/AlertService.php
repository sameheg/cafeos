<?php

namespace Modules\Inventory\Services;

use App\Business;
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
            $this->sendAlert($product, 'stock', $message);
        }
    }

    /**
     * Check sales volume of a product and trigger alert if exceeds threshold.
     */
    public function checkProductSales(Product $product, int $soldQuantity): void
    {
        if (!is_null($product->alert_sales_quantity) && $soldQuantity >= $product->alert_sales_quantity) {
            $message = "{$product->name} sales exceeded {$product->alert_sales_quantity}.";
            $this->sendAlert($product, 'sales', $message);
        }
    }

    /**
     * Persist alert information to the database.
     */
    protected function recordAlert(int $productId, string $type, string $message, int $periodMinutes = 60): void
    {
        $recentExists = DB::table('inventory_alerts')
            ->where('product_id', $productId)
            ->where('type', $type)
            ->where('created_at', '>=', now()->subMinutes($periodMinutes))
            ->exists();

        if ($recentExists) {
            return;
        }

        DB::table('inventory_alerts')->insert([
            'product_id' => $productId,
            'type' => $type,
            'message' => $message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Record the alert and notify the business owner.
     */
    private function sendAlert(Product $product, string $type, string $message): void
    {
        $this->recordAlert($product->id, $type, $message);

        $business = Business::with('owner')->find($product->business_id);
        $email = optional($business->owner)->email
            ?? data_get($business?->email_settings, 'mail_from_address')
            ?? config('mail.from.address');

        if ($email) {
            Notification::route('mail', [$email])
                ->notify(new InventoryAlertNotification($product, $message));
        }
    }
}
