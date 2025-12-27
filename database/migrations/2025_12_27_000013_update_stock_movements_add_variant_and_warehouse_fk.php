<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            // add variant reference
            $table->foreignId('variant_id')->nullable()->after('product_id')->constrained('product_variants')->nullOnDelete();

            // add FK to warehouses
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->nullOnDelete();

            $table->index(['product_id', 'variant_id']);
        });
    }

    public function down(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropIndex(['product_id', 'variant_id']);
            $table->dropForeign(['warehouse_id']);
            $table->dropForeign(['variant_id']);
            $table->dropColumn('variant_id');
        });
    }
};
