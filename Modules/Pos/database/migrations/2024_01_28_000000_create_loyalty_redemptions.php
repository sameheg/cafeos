<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loyalty_redemptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('order_id')->constrained('pos_orders')->cascadeOnDelete();
            $table->foreignUlid('customer_id')->nullable()->constrained('pos_customers')->nullOnDelete();
            $table->integer('points_used');
            $table->decimal('value', 12, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('loyalty_redemptions'); }
};
