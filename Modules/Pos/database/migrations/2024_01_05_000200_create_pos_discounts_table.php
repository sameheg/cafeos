<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_discounts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('order_id')->constrained('pos_orders')->cascadeOnDelete();
            $table->enum('scope', ['order','item'])->default('order');
            $table->decimal('amount', 12, 2)->default(0); // flat value
            $table->decimal('percent', 5, 2)->default(0); // percentage
            $table->string('code')->nullable()->index();  // voucher
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pos_discounts'); }
};
