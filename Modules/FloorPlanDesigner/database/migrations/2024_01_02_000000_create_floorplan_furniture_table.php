<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('floorplan_furniture', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('plan_id')->constrained('floorplans')->cascadeOnDelete();
            $table->string('type');           // table, chair, zone, door, bar
            $table->string('name')->index();
            $table->integer('capacity')->default(2);
            $table->string('status')->default('available'); // available, occupied, in-progress
            $table->integer('x');
            $table->integer('y');
            $table->integer('w')->default(80);
            $table->integer('h')->default(60);
            $table->integer('r')->default(0);
            $table->integer('layer')->default(0);
            $table->string('pos_table_id')->nullable()->index();
            $table->json('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['tenant_id','plan_id','type']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('floorplan_furniture');
    }
};
