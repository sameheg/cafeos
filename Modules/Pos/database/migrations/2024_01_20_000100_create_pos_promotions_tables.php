<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_promotions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('name');
            $table->string('code')->nullable()->index();
            $table->boolean('active')->default(true);
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
        Schema::create('pos_promotion_rules', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('promotion_id')->constrained('pos_promotions')->cascadeOnDelete();
            $table->string('type'); // percent_off, amount_off, bxgy, happy_hour
            $table->decimal('value', 12, 2)->default(0);
            $table->json('conditions')->nullable(); // e.g., min_total, after_hour, sku_in, order_type
            $table->timestamps();
        });
        Schema::create('pos_promotion_redemptions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('promotion_id')->constrained('pos_promotions')->cascadeOnDelete();
            $table->foreignUlid('order_id')->constrained('pos_orders')->cascadeOnDelete();
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->string('code_used')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pos_promotion_redemptions');
        Schema::dropIfExists('pos_promotion_rules');
        Schema::dropIfExists('pos_promotions');
    }
};
