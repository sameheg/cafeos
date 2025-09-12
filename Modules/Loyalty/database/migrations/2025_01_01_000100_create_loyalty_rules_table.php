<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loyalty_rules', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('name');
            $table->decimal('earn_rate', 8, 2);
            $table->boolean('stackable')->default(true);
            $table->timestamps();
            $table->unique(['tenant_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loyalty_rules');
    }
};
