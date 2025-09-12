<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procurement_bids', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->ulid('rfq_id');
            $table->string('supplier_id');
            $table->decimal('price', 15, 2);
            $table->timestamps();

            $table->foreign('rfq_id')->references('id')->on('procurement_rfqs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procurement_bids');
    }
};
