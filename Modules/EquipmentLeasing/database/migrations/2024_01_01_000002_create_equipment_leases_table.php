<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipment_leases', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->ulid('equipment_id');
            $table->date('end_date');
            $table->string('status');
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('equipment_listings');
            $table->index(['tenant_id', 'status'], 'equipment_leases_tenant_id_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_leases');
    }
};

