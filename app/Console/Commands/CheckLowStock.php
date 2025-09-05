<?php

namespace App\Console\Commands;

use App\Business;
use App\Product;
use App\Utils\NotificationUtil;
use App\Notifications\InventoryAlertNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class CheckLowStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pos:checkLowStock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications for products with low stock';

    /** @var NotificationUtil */
    protected $notificationUtil;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NotificationUtil $notificationUtil)
    {
        parent::__construct();
        $this->notificationUtil = $notificationUtil;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $businesses = Business::with('owner')->get();

        foreach ($businesses as $business) {
            $products = Product::join('variation_location_details as vld', 'products.id', '=', 'vld.product_id')
                ->where('products.business_id', $business->id)
                ->where('products.enable_stock', 1)
                ->whereNotNull('products.alert_quantity')
                ->where('vld.qty_available', '<', DB::raw('products.alert_quantity'))
                ->select('products.*', 'vld.qty_available as quantity_available')
                ->get();

            if ($products->isEmpty()) {
                continue;
            }

            $owner = $business->owner;

            foreach ($products as $product) {
                $message = $product->name . ' stock is low. Available: ' . (float) $product->quantity_available . ' (alert at ' . (float) $product->alert_quantity . ')';

                if (!empty($owner) && !empty($owner->email) && !empty($business->email_settings)) {
                    $this->notificationUtil->configureEmail(['email_settings' => $business->email_settings]);
                    $owner->notify(new InventoryAlertNotification($product, $message));
                }

                if (!empty($owner) && !empty($owner->contact_number) && !empty($business->sms_settings)) {
                    $data = [
                        'sms_body' => $message,
                        'whatsapp_text' => $message,
                        'sms_settings' => $business->sms_settings,
                        'mobile_number' => $owner->contact_number,
                    ];

                    $this->notificationUtil->sendSms($data);
                    $this->notificationUtil->sendWhatsapp($data);
                }

                $this->notificationUtil->activityLog($product, 'low_stock_alert', null, [
                    'quantity_available' => $product->quantity_available,
                    'alert_quantity' => $product->alert_quantity,
                ], false, $business->id);
            }
        }
    }
}
