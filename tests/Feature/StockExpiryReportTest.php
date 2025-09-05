<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use App\Currency;
use App\User;
use App\Business;
use App\BusinessLocation;
use App\Unit;
use App\Product;
use App\ProductVariation;
use App\Variation;
use App\Contact;
use App\Transaction;
use App\PurchaseLine;
use App\Http\Middleware\VerifyCsrfToken;

class StockExpiryReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_reference_number_and_expiry_edit_flow()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        // create currency
        $currency = Currency::create([
            'country' => 'USA',
            'currency' => 'Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        // create user
        $user = User::create([
            'surname' => 'Mr',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'language' => 'en',
        ]);

        // create business
        $business = Business::create([
            'name' => 'Test Biz',
            'currency_id' => $currency->id,
            'start_date' => '2020-01-01',
            'tax_number_1' => '',
            'tax_label_1' => '',
            'default_profit_percent' => 0,
            'owner_id' => $user->id,
            'time_zone' => 'UTC',
            'fy_start_month' => 1,
            'accounting_method' => 'fifo',
            'sell_price_tax' => 'includes',
            'enable_tooltip' => 1,
        ]);

        // attach business to user
        $user->business_id = $business->id;
        $user->save();

        // permission
        Permission::create(['name' => 'stock_report.view', 'guard_name' => 'web']);
        $user->givePermissionTo('stock_report.view');

        // location
        $location = BusinessLocation::create([
            'business_id' => $business->id,
            'name' => 'Main Location',
            'country' => 'USA',
            'state' => 'CA',
            'city' => 'LA',
            'zip_code' => '90001',
        ]);

        // unit
        $unit = Unit::create([
            'business_id' => $business->id,
            'actual_name' => 'Pieces',
            'short_name' => 'Pc',
            'allow_decimal' => 0,
            'created_by' => $user->id,
        ]);

        // product
        $product = Product::create([
            'name' => 'Test Product',
            'business_id' => $business->id,
            'type' => 'single',
            'unit_id' => $unit->id,
            'tax_type' => 'inclusive',
            'enable_stock' => 1,
            'alert_quantity' => 0,
            'sku' => 'TESTSKU',
            'barcode_type' => 'C39',
            'created_by' => $user->id,
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

        // contact
        $contact = Contact::create([
            'business_id' => $business->id,
            'type' => 'supplier',
            'name' => 'Supplier',
            'mobile' => '1234567890',
            'created_by' => $user->id,
        ]);

        // transaction
        $transaction = Transaction::create([
            'business_id' => $business->id,
            'location_id' => $location->id,
            'type' => 'purchase',
            'status' => 'received',
            'payment_status' => 'paid',
            'contact_id' => $contact->id,
            'ref_no' => 'REF123',
            'transaction_date' => Carbon::now(),
            'total_before_tax' => 10,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'final_total' => 10,
            'created_by' => $user->id,
        ]);

        // purchase line
        $purchase_line = PurchaseLine::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'variation_id' => $variation->id,
            'quantity' => 1,
            'purchase_price' => 10,
            'purchase_price_inc_tax' => 10,
            'item_tax' => 0,
            'mfg_date' => Carbon::now()->subDay()->toDateString(),
            'exp_date' => Carbon::now()->addDays(5)->toDateString(),
            'lot_number' => 'LOT1',
        ]);

        $this->actingAs($user);
        session(['user.business_id' => $business->id]);

        // datatable request
        $response = $this->get('/reports/stock-expiry', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertStatus(200);
        $this->assertStringContainsString('REF123', $response->getContent());

        // modal request
        $modal = $this->get('/reports/stock-expiry-edit-modal/'.$purchase_line->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $modal->assertStatus(200)->assertSee('REF123');

        // update expiry
        $new_exp = Carbon::now()->addDays(10)->format('m/d/Y');
        $update = $this->post('/reports/stock-expiry-update', [
            'purchase_line_id' => $purchase_line->id,
            'exp_date' => $new_exp,
        ], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $update->assertStatus(200)->assertJson(['success' => 1]);

        $this->assertEquals(Carbon::createFromFormat('m/d/Y', $new_exp)->format('Y-m-d'), $purchase_line->fresh()->exp_date);
    }
}
