<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kiosk_orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->ulid('kiosk_id');
            $table->decimal('total', 10, 2);
            $table->enum('status', ['queued', 'paid'])->default('queued');
            $table->timestamps();
            $table->index(['kiosk_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kiosk_orders');
    }
};
