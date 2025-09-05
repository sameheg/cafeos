<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Business;
use App\BusinessLocation;
use App\Contact;
use App\Currency;
use App\Product;
use App\ProductVariation;
use App\PurchaseLine;
use App\Transaction;
use App\Unit;
use App\User;
use App\Variation;
use App\TransactionSellLinesPurchaseLines;
use Illuminate\Support\Str;

class SupplierStockReportTest extends TestCase
{
    use RefreshDatabase;

    private function setupEnvironment()
    {
        $user = User::factory()->create();
        $currency = Currency::create([
            'country' => 'USA',
            'currency' => 'USD',
            'code' => 'USD',
            'symbol' => '$',
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        $business = Business::create([
            'name' => 'Biz',
            'currency_id' => $currency->id,
            'start_date' => '2023-01-01',
            'tax_number_1' => '1',
            'tax_label_1' => 'T1',
            'owner_id' => $user->id,
            'time_zone' => 'UTC',
            'fy_start_month' => 1,
            'accounting_method' => 'fifo',
            'default_profit_percent' => 0,
            'sell_price_tax' => 'includes',
        ]);

        $location1 = BusinessLocation::create([
            'business_id' => $business->id,
            'name' => 'L1',
            'country' => 'US',
            'state' => 'CA',
            'city' => 'LA',
            'zip_code' => '12345',
        ]);
        $location2 = BusinessLocation::create([
            'business_id' => $business->id,
            'name' => 'L2',
            'country' => 'US',
            'state' => 'CA',
            'city' => 'SF',
            'zip_code' => '67890',
        ]);

        $unit = Unit::create([
            'business_id' => $business->id,
            'actual_name' => 'Unit',
            'short_name' => 'u',
            'allow_decimal' => 0,
            'created_by' => $user->id,
        ]);

        $product = Product::create([
            'name' => 'Test',
            'business_id' => $business->id,
            'type' => 'single',
            'unit_id' => $unit->id,
            'sku' => Str::random(5),
            'barcode_type' => 'C39',
            'enable_stock' => 1,
            'alert_quantity' => 0,
            'tax_type' => 'inclusive',
            'created_by' => $user->id,
        ]);

        $pv = ProductVariation::create([
            'name' => 'PV',
            'product_id' => $product->id,
            'is_dummy' => 0,
        ]);

        $variation = Variation::create([
            'name' => 'VAR',
            'product_id' => $product->id,
            'sub_sku' => 'SKU1',
            'product_variation_id' => $pv->id,
            'default_purchase_price' => 5,
            'dpp_inc_tax' => 5,
            'default_sell_price' => 10,
            'sell_price_inc_tax' => 10,
        ]);

        $supplier = Contact::create([
            'business_id' => $business->id,
            'type' => 'supplier',
            'name' => 'Supplier',
        ]);

        return [$business, $user, $supplier, $product, $variation, $location1, $location2];
    }

    public function test_supplier_stock_report_without_transfer()
    {
        list($business, $user, $supplier, $product, $variation, $location1) = $this->setupEnvironment();

        $purchase = Transaction::create([
            'business_id' => $business->id,
            'type' => 'purchase',
            'status' => 'received',
            'payment_status' => 'paid',
            'contact_id' => $supplier->id,
            'transaction_date' => now(),
            'total_before_tax' => 0,
            'final_total' => 0,
            'created_by' => $user->id,
            'location_id' => $location1->id,
        ]);

        PurchaseLine::create([
            'transaction_id' => $purchase->id,
            'product_id' => $product->id,
            'variation_id' => $variation->id,
            'quantity' => 5,
            'purchase_price' => 5,
            'purchase_price_inc_tax' => 5,
            'item_tax' => 0,
            'tax_id' => null,
        ]);

        $response = $this->withSession(['user.business_id' => $business->id])
            ->get('/contacts/stock-report/' . $supplier->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $data = $response->decodeResponseJson()['data'][0];

        $this->assertStringContainsString('data-orig-value="5"', $data['purchase_quantity']);
        $this->assertStringContainsString('data-orig-value="5"', $data['current_stock']);
        $this->assertStringContainsString('data-orig-value="0"', $data['total_quantity_transfered']);
    }

    public function test_supplier_stock_report_accounts_for_transfer()
    {
        list($business, $user, $supplier, $product, $variation, $location1, $location2) = $this->setupEnvironment();

        $purchase = Transaction::create([
            'business_id' => $business->id,
            'type' => 'purchase',
            'status' => 'received',
            'payment_status' => 'paid',
            'contact_id' => $supplier->id,
            'transaction_date' => now(),
            'total_before_tax' => 0,
            'final_total' => 0,
            'created_by' => $user->id,
            'location_id' => $location1->id,
        ]);

        $pl = PurchaseLine::create([
            'transaction_id' => $purchase->id,
            'product_id' => $product->id,
            'variation_id' => $variation->id,
            'quantity' => 10,
            'purchase_price' => 5,
            'purchase_price_inc_tax' => 5,
            'item_tax' => 0,
            'tax_id' => null,
            'quantity_sold' => 3,
        ]);

        $sell_transfer = Transaction::create([
            'business_id' => $business->id,
            'type' => 'sell_transfer',
            'status' => 'final',
            'payment_status' => 'paid',
            'contact_id' => null,
            'transaction_date' => now(),
            'total_before_tax' => 0,
            'final_total' => 0,
            'created_by' => $user->id,
            'location_id' => $location1->id,
        ]);

        $sell_line = $sell_transfer->sell_lines()->create([
            'product_id' => $product->id,
            'variation_id' => $variation->id,
            'quantity' => 3,
            'unit_price' => 0,
            'unit_price_inc_tax' => 0,
            'item_tax' => 0,
        ]);

        TransactionSellLinesPurchaseLines::create([
            'sell_line_id' => $sell_line->id,
            'purchase_line_id' => $pl->id,
            'quantity' => 3,
        ]);

        $purchase_transfer = Transaction::create([
            'business_id' => $business->id,
            'type' => 'purchase_transfer',
            'status' => 'received',
            'payment_status' => 'paid',
            'contact_id' => null,
            'transaction_date' => now(),
            'total_before_tax' => 0,
            'final_total' => 0,
            'created_by' => $user->id,
            'location_id' => $location2->id,
            'transfer_parent_id' => $sell_transfer->id,
        ]);

        PurchaseLine::create([
            'transaction_id' => $purchase_transfer->id,
            'product_id' => $product->id,
            'variation_id' => $variation->id,
            'quantity' => 3,
            'purchase_price' => 5,
            'purchase_price_inc_tax' => 5,
            'item_tax' => 0,
            'tax_id' => null,
        ]);

        $response = $this->withSession(['user.business_id' => $business->id])
            ->get('/contacts/stock-report/' . $supplier->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $data = $response->decodeResponseJson()['data'][0];

        $this->assertStringContainsString('data-orig-value="13"', $data['purchase_quantity']);
        $this->assertStringContainsString('data-orig-value="3"', $data['total_quantity_transfered']);
        $this->assertStringContainsString('data-orig-value="10"', $data['current_stock']);
    }
}
