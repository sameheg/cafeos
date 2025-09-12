<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_bills', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('order_id')->constrained('pos_orders')->cascadeOnDelete();
            $table->string('label')->nullable(); // Bill A / Bill B
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('service_amount', 12, 2)->default(0);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('paid_total', 12, 2)->default(0);
            $table->decimal('outstanding_total', 12, 2)->default(0);
            $table->timestamps();
        });
        Schema::create('pos_bill_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('bill_id')->constrained('pos_bills')->cascadeOnDelete();
            $table->foreignUlid('order_item_id')->constrained('pos_items')->cascadeOnDelete();
            $table->integer('qty')->default(1);
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('line_total', 12, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pos_bill_items');
        Schema::dropIfExists('pos_bills');
    }
};
