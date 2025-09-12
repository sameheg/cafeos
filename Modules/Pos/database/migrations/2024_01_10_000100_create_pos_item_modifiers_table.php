<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_item_modifiers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('item_id')->constrained('pos_items')->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pos_item_modifiers'); }
};
