<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_courses', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('title');
            $table->boolean('mandatory')->default(false);
            $table->timestamps();
            $table->index(['tenant_id', 'mandatory'], 'tenant_id_mandatory');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_courses');
    }
};
