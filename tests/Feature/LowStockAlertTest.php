<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Mockery;
use App\Currency;
use App\User;
use App\Business;
use App\BusinessLocation;
use App\Unit;
use App\Product;
use App\ProductVariation;
use App\Variation;
use App\VariationLocationDetails;
use App\Utils\NotificationUtil;
use App\Notifications\CustomerNotification;
use Spatie\Activitylog\Models\Activity;

class LowStockAlertTest extends TestCase
{
    use RefreshDatabase;

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_low_stock_command_sends_notifications_and_logs_activity()
    {
        Notification::fake();

        // currency
        $currency = Currency::create([
            'country' => 'USA',
            'currency' => 'Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        // owner user
        $owner = User::create([
            'surname' => 'Mr',
            'first_name' => 'Owner',
            'last_name' => 'User',
            'username' => 'owner',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
            'contact_number' => '1234567890',
            'language' => 'en',
        ]);

        // business
        $business = Business::create([
            'name' => 'Test Biz',
            'currency_id' => $currency->id,
            'start_date' => '2020-01-01',
            'tax_number_1' => '',
            'tax_label_1' => '',
            'default_profit_percent' => 0,
            'owner_id' => $owner->id,
            'time_zone' => 'UTC',
            'fy_start_month' => 1,
            'accounting_method' => 'fifo',
            'sell_price_tax' => 'includes',
            'enable_tooltip' => 1,
        ]);

        $owner->business_id = $business->id;
        $owner->save();

        $location = BusinessLocation::create([
            'business_id' => $business->id,
            'name' => 'Main Location',
            'country' => 'USA',
            'state' => 'CA',
            'city' => 'LA',
            'zip_code' => '90001',
        ]);

        $unit = Unit::create([
            'business_id' => $business->id,
            'actual_name' => 'Pieces',
            'short_name' => 'Pc',
            'allow_decimal' => 0,
            'created_by' => $owner->id,
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'business_id' => $business->id,
            'type' => 'single',
            'unit_id' => $unit->id,
            'tax_type' => 'inclusive',
            'enable_stock' => 1,
            'alert_quantity' => 10,
            'sku' => 'TESTSKU',
            'barcode_type' => 'C39',
            'created_by' => $owner->id,
        ]);

        $pv = ProductVariation::create([
            'name' => 'Default',
            'product_id' => $product->id,
            'is_dummy' => 0,
        ]);

        $variation = Variation::create([
            'name' => 'Default',
            'product_id' => $product->id,
            'sub_sku' => 'TESTSKU',
            'product_variation_id' => $pv->id,
        ]);

        VariationLocationDetails::create([
            'product_id' => $product->id,
            'product_variation_id' => $pv->id,
            'variation_id' => $variation->id,
            'location_id' => $location->id,
            'qty_available' => 5,
        ]);

        // mock NotificationUtil
        $notificationMock = Mockery::mock(NotificationUtil::class)->makePartial();
        $notificationMock->shouldReceive('sendSms')->once();
        $notificationMock->shouldReceive('sendWhatsapp')->once();
        $this->app->instance(NotificationUtil::class, $notificationMock);

        Artisan::call('pos:checkLowStock');

        Notification::assertSentOnDemand(CustomerNotification::class, function ($notification, $channels, $notifiable) use ($owner) {
            return $notifiable->routes['mail'] === $owner->email;
        });

        $this->assertTrue(Activity::where('description', 'low_stock_alert')->exists());
    }
}
