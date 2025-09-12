<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('floorplan_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('plan_id')->constrained('floorplans')->cascadeOnDelete();
            $table->integer('order_count')->default(0);
            $table->decimal('revenue', 12, 2)->default(0);
            $table->decimal('avg_spend', 12, 2)->default(0);
            $table->decimal('turnover', 8, 2)->default(0); // avg orders per table
            $table->integer('hot_index')->default(0); // synthetic score for heatmap
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('floorplan_stats');
    }
};
