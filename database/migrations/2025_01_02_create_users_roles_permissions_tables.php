<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('tenant')->create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::connection('tenant')->create('roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->string('name');
            $table->timestamps();
        });

        Schema::connection('tenant')->create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->string('name');
            $table->timestamps();
        });

        Schema::connection('tenant')->create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('user_id')->constrained('users');
            $table->primary(['role_id', 'user_id']);
        });

        Schema::connection('tenant')->create('permission_role', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained('permissions');
            $table->foreignId('role_id')->constrained('roles');
            $table->primary(['permission_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::connection('tenant')->dropIfExists('permission_role');
        Schema::connection('tenant')->dropIfExists('role_user');
        Schema::connection('tenant')->dropIfExists('permissions');
        Schema::connection('tenant')->dropIfExists('roles');
        Schema::connection('tenant')->dropIfExists('users');
    }
};
