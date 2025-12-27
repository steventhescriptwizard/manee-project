<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // If an incomplete `stocks` table exists (left from a failed migration), drop it so we can recreate correctly
        Schema::dropIfExists('stocks');

        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            // warehouse_id is optional; don't add a FK constraint because a `warehouses` table may not exist
            $table->foreignId('warehouse_id')->nullable()->index();
            $table->unsignedInteger('stock_in')->default(0);
            $table->unsignedInteger('stock_out')->default(0);
            $table->integer('current_stock')->default(0);
            $table->unsignedInteger('minimum_stock')->default(0);
            $table->timestamp('last_stock_update')->nullable();
            $table->timestamps();

            $table->index(['product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
