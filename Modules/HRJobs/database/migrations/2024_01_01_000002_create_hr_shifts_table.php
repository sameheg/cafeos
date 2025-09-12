<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hr_shifts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->ulid('employee_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->enum('status', ['scheduled', 'attended', 'paid', 'absent'])->default('scheduled');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('hr_employees');
            $table->index(['employee_id', 'status'], 'hr_shifts_employee_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_shifts');
    }
};

