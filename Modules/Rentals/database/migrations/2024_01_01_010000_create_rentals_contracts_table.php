<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rentals_contracts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('listing_id')->constrained('rentals_listings');
            $table->string('renter_id');
            $table->date('end_date');
            $table->enum('status', ['active', 'disputed'])->default('active');
            $table->timestamps();
            $table->index(['listing_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals_contracts');
    }
};
