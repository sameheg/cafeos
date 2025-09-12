<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('franchise_branches', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id');
            $table->string('name');
            $table->json('overrides')->nullable();
            $table->timestamps();
            $table->index(['tenant_id', 'name']);
        });

        Schema::create('franchise_templates', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id');
            $table->string('type');
            $table->json('data')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->string('state')->default('Local');
            $table->timestamps();
            $table->index(['tenant_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('franchise_templates');
        Schema::dropIfExists('franchise_branches');
    }
};
