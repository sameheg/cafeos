<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('order_id')->constrained('pos_orders')->cascadeOnDelete();
            $table->string('method'); // cash, card, wallet, online
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('captured'); // pending, captured, failed, refunded
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pos_payments'); }
};
