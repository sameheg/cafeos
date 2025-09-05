<?php

namespace Tests\Unit;

use App\Business;
use App\Console\Commands\AutoSendPaymentReminder;
use App\Contact;
use App\Currency;
use App\NotificationLog;
use App\NotificationTemplate;
use App\Transaction;
use App\User;
use App\Utils\NotificationUtil;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Tests\TestCase;

class AutoSendPaymentReminderTest extends TestCase
{
    use RefreshDatabase;

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_logs_are_created_for_all_channels()
    {
        Notification::fake();

        $currency = Currency::create([
            'country' => 'Country',
            'currency' => 'USD',
            'code' => 'USD',
            'symbol' => '$',
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        $owner = User::factory()->create();

        $business = Business::create([
            'name' => 'Biz',
            'currency_id' => $currency->id,
            'start_date' => Carbon::now(),
            'tax_number_1' => '111',
            'tax_label_1' => 'GST',
            'default_profit_percent' => 0,
            'owner_id' => $owner->id,
            'time_zone' => 'UTC',
            'fy_start_month' => 1,
            'accounting_method' => 'fifo',
            'sell_price_tax' => 'includes',
        ]);

        $contact = Contact::create([
            'business_id' => $business->id,
            'type' => 'customer',
            'name' => 'John Doe',
            'mobile' => '1234567890',
            'created_by' => $owner->id,
            'email' => 'john@example.com',
        ]);

        NotificationTemplate::create([
            'business_id' => $business->id,
            'template_for' => 'payment_reminder',
            'subject' => 'Sub',
            'sms_body' => 'Sms body',
            'whatsapp_text' => 'Wa text',
            'email_body' => 'Email body',
            'auto_send' => 1,
            'auto_send_sms' => 1,
            'auto_send_wa_notif' => 1,
        ]);

        Transaction::create([
            'business_id' => $business->id,
            'type' => 'sell',
            'status' => 'final',
            'payment_status' => 'due',
            'contact_id' => $contact->id,
            'transaction_date' => Carbon::now()->subDays(40),
            'total_before_tax' => 0,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'shipping_charges' => 0,
            'final_total' => 0,
            'created_by' => $owner->id,
            'pay_term_number' => 30,
            'pay_term_type' => 'days',
        ]);

        $mock = Mockery::mock(NotificationUtil::class);
        $mock->shouldReceive('replaceTags')->andReturnUsing(function ($business, $data, $sell) {
            return $data;
        });
        $mock->shouldReceive('sendSms')->once();
        $mock->shouldReceive('sendWhatsapp')->once();
        $mock->shouldReceive('activityLog')->times(3);

        $command = new AutoSendPaymentReminder($mock);
        $command->handle();

        $this->assertDatabaseHas('notification_logs', [
            'contact_id' => $contact->id,
            'channel' => 'email',
            'message' => 'Email body',
            'status' => 'sent',
        ]);
        $this->assertDatabaseHas('notification_logs', [
            'contact_id' => $contact->id,
            'channel' => 'sms',
            'message' => 'Sms body',
            'status' => 'sent',
        ]);
        $this->assertDatabaseHas('notification_logs', [
            'contact_id' => $contact->id,
            'channel' => 'whatsapp',
            'message' => 'Wa text',
            'status' => 'sent',
        ]);
    }
}
