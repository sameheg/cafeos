<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->decimal('amount', 12, 2);
            $table->string('reason')->nullable();
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        Schema::create('refund_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refund_id');
            $table->unsignedBigInteger('order_item_id');
            $table->decimal('qty', 12, 3)->default(0);
            $table->decimal('amount', 12, 2)->default(0);
            $table->timestamps();
            $table->foreign('refund_id')->references('id')->on('refunds')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refund_items');
        Schema::dropIfExists('refunds');
    }
};
