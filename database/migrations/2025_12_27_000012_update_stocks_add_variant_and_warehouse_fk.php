<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            // Add variant reference (nullable) for variant-level inventory
            $table->foreignId('variant_id')->nullable()->after('product_id')->constrained('product_variants')->nullOnDelete();

            // Add FK to warehouses (warehouse table exists now)
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->nullOnDelete();

            // Add composite unique to avoid duplicate stock rows per product/variant/warehouse
            $table->unique(['product_id', 'variant_id', 'warehouse_id'], 'stocks_product_variant_warehouse_unique');
        });
    }

    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropUnique('stocks_product_variant_warehouse_unique');
            $table->dropForeign(['warehouse_id']);
            $table->dropForeign(['variant_id']);
            $table->dropColumn('variant_id');
        });
    }
};
