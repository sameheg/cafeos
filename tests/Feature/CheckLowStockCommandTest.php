<?php

namespace Tests\Feature;

use App\Notifications\CustomerNotification;
use App\Utils\NotificationUtil;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Mockery;
use Tests\TestCase;

class CheckLowStockCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
        });

        Schema::create('business', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->string('name');
            $table->text('email_settings')->nullable();
            $table->text('sms_settings')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->string('name');
            $table->boolean('enable_stock')->default(1);
            $table->decimal('alert_quantity', 8, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('variation_location_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->decimal('qty_available', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('variation_location_details');
        Schema::dropIfExists('products');
        Schema::dropIfExists('business');
        Schema::dropIfExists('users');
        Mockery::close();
        parent::tearDown();
    }

    public function test_command_sends_notifications_using_in_memory_sqlite()
    {
        Notification::fake();

        $ownerId = DB::table('users')->insertGetId([
            'email' => 'owner@example.com',
            'contact_number' => '1234567890',
        ]);

        $businessId = DB::table('business')->insertGetId([
            'name' => 'Test Biz',
            'owner_id' => $ownerId,
        ]);

        $productId = DB::table('products')->insertGetId([
            'business_id' => $businessId,
            'name' => 'Test Product',
            'enable_stock' => 1,
            'alert_quantity' => 10,
        ]);

        DB::table('variation_location_details')->insert([
            'product_id' => $productId,
            'qty_available' => 5,
        ]);

        $notificationMock = Mockery::mock(NotificationUtil::class)->makePartial();
        $notificationMock->shouldReceive('sendSms')->once();
        $notificationMock->shouldReceive('sendWhatsapp')->once();
        $this->app->instance(NotificationUtil::class, $notificationMock);

        Artisan::call('pos:checkLowStock');

        Notification::assertSentOnDemand(CustomerNotification::class);
    }
}
