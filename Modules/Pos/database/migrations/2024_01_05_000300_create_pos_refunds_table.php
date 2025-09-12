<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_refunds', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('order_id')->constrained('pos_orders')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('reason')->nullable();
            $table->json('items')->nullable(); // which items were refunded
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pos_refunds'); }
};
