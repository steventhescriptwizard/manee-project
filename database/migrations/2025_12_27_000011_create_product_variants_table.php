<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('sku', 100)->nullable()->unique();
            $table->string('barcode', 100)->nullable()->unique();
            $table->json('attributes')->nullable(); // e.g. {"size":"M","color":"red"}
            $table->decimal('price', 12, 2)->nullable();
            $table->boolean('track_inventory')->default(true);
            $table->decimal('weight', 10, 3)->nullable();
            $table->string('unit_of_measure', 50)->nullable();
            $table->timestamps();

            $table->index(['product_id']);
            $table->index(['sku']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
