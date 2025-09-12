<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hr_payrolls', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->ulid('employee_id');
            $table->date('period');
            $table->string('amount');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('hr_employees');
            $table->index(['employee_id', 'period'], 'hr_payrolls_employee_period_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_payrolls');
    }
};

