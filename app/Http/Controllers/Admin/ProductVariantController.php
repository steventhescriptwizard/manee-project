<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Warehouse;
use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $variants = $product->variants()->latest()->paginate(10);
        return view('admin.products.variants.index', compact('product', 'variants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('admin.products.variants.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductVariantRequest $request, Product $product)
    {
        $data = $request->validated();
        
        // Construct variant name if not provided
        if (empty($data['variant_name'])) {
            $data['variant_name'] = trim(($data['color'] ?? '') . ' ' . ($data['size'] ?? ''));
        }

        $attributes = [
            'name' => $data['variant_name'],
            'color' => $data['color'] ?? null,
            'size' => $data['size'] ?? null,
        ];
        $data['attributes'] = $attributes;

        // Auto-generate SKU if empty
        if (empty($data['sku'])) {
            $baseSku = $product->sku ?: str($product->product_name)->slug()->upper();
            $variantSuffix = collect([$data['color'], $data['size']])
                ->filter()
                ->map(fn($v) => str($v)->slug()->upper())
                ->implode('-');
            
            $generatedSku = $variantSuffix ? "{$baseSku}-{$variantSuffix}" : "{$baseSku}-VAR";
            
            // Ensure uniqueness
            $count = 1;
            $finalSku = $generatedSku;
            while (ProductVariant::where('sku', $finalSku)->exists()) {
                $finalSku = "{$generatedSku}-" . ($count++);
            }
            $data['sku'] = $finalSku;
        }

        if ($request->hasFile('variant_image')) {
            $imagePath = $request->file('variant_image')->store('products/variants', 'public');
            $data['image_path'] = $imagePath;
        }

        $variant = $product->variants()->create($data);

        // Initialize stock if tracking
        if ($variant->track_inventory) {
            $defaultWarehouse = Warehouse::first();
            if ($defaultWarehouse) {
                $variant->stocks()->create([
                    'product_id' => $product->id,
                    'warehouse_id' => $defaultWarehouse->id,
                    'current_stock' => $request->initial_stock ?? 0,
                    'stock_in' => $request->initial_stock ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, ProductVariant $variant)
    {
        return view('admin.products.variants.edit', compact('product', 'variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductVariantRequest $request, Product $product, ProductVariant $variant)
    {
        $data = $request->validated();
        
        // Construct variant name if not provided
        if (empty($data['variant_name'])) {
            $data['variant_name'] = trim(($data['color'] ?? '') . ' ' . ($data['size'] ?? ''));
        }

        $attributes = [
            'name' => $data['variant_name'],
            'color' => $data['color'] ?? null,
            'size' => $data['size'] ?? null,
        ];
        $data['attributes'] = $attributes;

        if ($request->hasFile('variant_image')) {
            // Delete old image if exists
            if ($variant->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($variant->image_path);
            }
            $imagePath = $request->file('variant_image')->store('products/variants', 'public');
            $data['image_path'] = $imagePath;
        }

        $variant->update($data);

        // Update stock if tracking
        if ($variant->track_inventory && isset($request->current_stock)) {
            $defaultWarehouse = Warehouse::first();
            if ($defaultWarehouse) {
                $stock = $variant->stocks()->where('warehouse_id', $defaultWarehouse->id)->first();
                if ($stock) {
                    $stock->update([
                        'current_stock' => $request->current_stock,
                    ]);
                } else {
                    $variant->stocks()->create([
                        'product_id' => $product->id,
                        'warehouse_id' => $defaultWarehouse->id,
                        'current_stock' => $request->current_stock,
                        'stock_in' => $request->current_stock,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductVariant $variant)
    {
        $variant->delete();

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant deleted successfully.');
    }
}
