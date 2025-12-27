<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('sku', 100)->unique();
            $table->string('barcode', 100)->nullable()->unique();
            $table->decimal('price', 12, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('image_main', 1024)->nullable();
            $table->boolean('track_inventory')->default(true);
            $table->decimal('weight', 10, 3)->nullable();
            $table->string('unit_of_measure', 50)->nullable();
            $table->timestamps();

            // Indexes
            $table->index('product_name');
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
