<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procurement_grns', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->ulid('po_id');
            $table->decimal('received_qty', 15, 2);
            $table->timestamps();

            $table->foreign('po_id')->references('id')->on('procurement_pos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procurement_grns');
    }
};
