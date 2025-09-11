<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_batches', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->ulid('item_id');
            $table->string('batch_number');
            $table->decimal('quantity', 12, 3);
            $table->date('expiry');
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('inventory_items')->cascadeOnDelete();
            $table->index(['item_id', 'expiry']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_batches');
    }
};
