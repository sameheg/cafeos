<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pos_tables', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('floorplan_id')->nullable()->constrained('floorplans')->cascadeOnDelete();
            $table->string('furniture_id')->nullable();
            $table->string('name');
            $table->integer('capacity')->default(2);
            $table->enum('status', ['available','occupied'])->default('available');
            $table->foreignUlid('current_order_id')->nullable()->constrained('pos_orders')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pos_tables');
    }
};
