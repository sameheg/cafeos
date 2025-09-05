<?php

namespace Tests\Feature;

use App\Business;
use App\BusinessLocation;
use App\Contact;
use App\Currency;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class TransactionsExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_transactions_can_be_exported()
    {
        Excel::fake();

        $currency = Currency::create([
            'country' => 'USA',
            'currency' => 'Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        $user = User::create([
            'surname' => 'Mr',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'language' => 'en',
        ]);

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

        $user->business_id = $business->id;
        $user->save();

        Permission::create(['name' => 'reports.export_transactions', 'guard_name' => 'web']);
        $user->givePermissionTo('reports.export_transactions');

        $location = BusinessLocation::create([
            'business_id' => $business->id,
            'name' => 'Main Location',
            'country' => 'USA',
            'state' => 'CA',
            'city' => 'LA',
            'zip_code' => '90001',
        ]);

        $contact = Contact::create([
            'business_id' => $business->id,
            'type' => 'customer',
            'name' => 'Customer',
            'mobile' => '1234567890',
            'created_by' => $user->id,
        ]);

        Transaction::create([
            'business_id' => $business->id,
            'location_id' => $location->id,
            'type' => 'sell',
            'status' => 'final',
            'payment_status' => 'paid',
            'contact_id' => $contact->id,
            'ref_no' => 'REF100',
            'transaction_date' => Carbon::now(),
            'total_before_tax' => 100,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'final_total' => 100,
            'created_by' => $user->id,
        ]);

        $this->actingAs($user);
        session(['user.business_id' => $business->id]);

        $response = $this->get('/reports/export-transactions');
        $response->assertStatus(200);

        Excel::assertDownloaded('transactions.xlsx');
    }
}
