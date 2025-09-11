<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_registries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('module');
            $table->boolean('enabled')->default(true);
            $table->json('config')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'module']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_registries');
    }
};
