<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('floorplan_zones', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('plan_id')->constrained('floorplans')->cascadeOnDelete();
            $table->string('name');
            $table->json('coords');
            $table->timestamps();
            $table->index(['plan_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floorplan_zones');
    }
};
