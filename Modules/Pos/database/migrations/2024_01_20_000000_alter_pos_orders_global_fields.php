<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pos_orders', function (Blueprint $table) {
            $table->string('order_type')->default('dine_in'); // dine_in, takeaway, delivery
            $table->string('branch_id')->nullable()->index();
            $table->string('delivery_address')->nullable();
            $table->string('delivery_status')->nullable(); // assigned, picked_up, delivered, canceled
            $table->string('driver_id')->nullable()->index();
            // compliance (e-invoice/e-tax)
            $table->string('tax_id')->nullable();
            $table->string('invoice_number')->nullable()->index();
        });
    }
    public function down(): void {
        Schema::table('pos_orders', function (Blueprint $table) {
            $table->dropColumn(['order_type','branch_id','delivery_address','delivery_status','driver_id','tax_id','invoice_number']);
        });
    }
};
