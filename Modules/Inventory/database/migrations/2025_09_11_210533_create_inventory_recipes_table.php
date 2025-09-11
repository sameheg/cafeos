<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_recipes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->ulid('product_id');
            $table->json('ingredients');
            $table->timestamps();
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_recipes');
    }
};
