<?php

namespace App\Console\Commands;

use App\Business;
use App\Product;
use App\Utils\NotificationUtil;
use App\Notifications\CustomerNotification;
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

            $message = $products->map(function ($p) {
                return $p->name . ' (' . (float) $p->quantity_available . ')';
            })->implode(', ');

            $data = [
                'subject' => 'Low Stock Alert',
                'email_body' => $message,
                'sms_body' => $message,
                'whatsapp_text' => $message,
                'email_settings' => $business->email_settings ?? [],
                'sms_settings' => $business->sms_settings ?? [],
            ];

            $owner = $business->owner;

            if (!empty($owner) && !empty($owner->email)) {
                Notification::route('mail', [$owner->email])->notify(new CustomerNotification($data));
            }

            if (!empty($owner) && !empty($owner->contact_number)) {
                $data['mobile_number'] = $owner->contact_number;
                $this->notificationUtil->sendSms($data);
                $this->notificationUtil->sendWhatsapp($data);
            }

            foreach ($products as $product) {
                $this->notificationUtil->activityLog($product, 'low_stock_alert', null, [
                    'quantity_available' => $product->quantity_available,
                    'alert_quantity' => $product->alert_quantity,
                ], false, $business->id);
            }
        }
    }
}
