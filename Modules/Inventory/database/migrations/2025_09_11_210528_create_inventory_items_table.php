<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('name');
            $table->decimal('quantity', 12, 3)->default(0);
            $table->string('unit');
            $table->decimal('reorder_level', 12, 3)->default(0);
            $table->timestamps();
            $table->unique(['tenant_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
