<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs_applications', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->foreignUlid('posting_id')->constrained('jobs_postings');
            $table->string('cv_path');
            $table->enum('status', ['applied', 'screened', 'hired', 'rejected']);
            $table->timestamps();
            $table->index(['posting_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs_applications');
    }
};
