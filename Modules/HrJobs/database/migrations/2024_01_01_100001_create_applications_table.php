<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->foreignId('job_id')->constrained('hr_jobs')->cascadeOnDelete();
            $table->foreignId('member_profile_id')->constrained('member_profiles');
            $table->string('resume')->nullable();
            $table->string('status')->default('submitted');
            $table->timestamps();
            $table->index('job_id');
            $table->index('tenant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
