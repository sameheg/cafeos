<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('franchises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('fee', 10, 2)->nullable();
            $table->timestamps();

            $table->index('tenant_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('franchises');
    }
};
