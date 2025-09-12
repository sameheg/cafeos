<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipment_listings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('name');
            $table->boolean('available')->default(true);
            $table->timestamps();

            $table->index(['tenant_id', 'available'], 'equipment_listings_tenant_id_available_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_listings');
    }
};

