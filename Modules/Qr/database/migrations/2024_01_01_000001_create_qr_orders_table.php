<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('qr_orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('qr_id')->constrained('qr_codes');
            $table->enum('status', ['placed','paid'])->default('placed');
            $table->decimal('total', 10, 2);
            $table->timestamps();
            $table->index(['qr_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_orders');
    }
};
