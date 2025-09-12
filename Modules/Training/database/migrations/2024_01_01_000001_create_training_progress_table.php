<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_progress', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->uuid('tenant_id')->index();
            $table->string('employee_id');
            $table->foreignUlid('course_id')->constrained('training_courses');
            $table->unsignedTinyInteger('percent')->default(0);
            $table->timestamps();
            $table->unique(['employee_id', 'course_id'], 'employee_id_course_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_progress');
    }
};
