<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Rentals\Enums\ListingType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('type', array_column(ListingType::cases(), 'value'));
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->index('tenant_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
