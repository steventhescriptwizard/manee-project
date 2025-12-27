<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image_main')) {
            $path = $request->file('image_main')->store('products', 'public');
            $data['image_main'] = $path;
        }

        $product = Product::create($data);

        if ($request->has('categories')) {
            $product->categories()->attach($request->categories);
        }

        if ($request->hasFile('product_gallery')) {
            foreach ($request->file('product_gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        // Initialize default stock in default warehouse if tracking enabled (simplified logic for now)
        // In a real app we might ask which warehouse
        if ($product->track_inventory) {
            $defaultWarehouse = \App\Models\Warehouse::first();
            if ($defaultWarehouse) {
                $product->stocks()->create([
                    'warehouse_id' => $defaultWarehouse->id,
                    'current_stock' => $request->initial_stock ?? 0,
                    'stock_in' => $request->initial_stock ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['categories', 'images', 'variants', 'stocks.warehouse']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('categories');
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image_main')) {
            // Delete old image
            if ($product->image_main) {
                Storage::disk('public')->delete($product->image_main);
            }
            $path = $request->file('image_main')->store('products', 'public');
            $data['image_main'] = $path;
        }

        $product->update($data);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->hasFile('product_gallery')) {
            foreach ($request->file('product_gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        if ($product->track_inventory && $request->has('current_stock')) {
            $defaultWarehouse = \App\Models\Warehouse::first();
            if ($defaultWarehouse) {
                $product->stocks()->updateOrCreate(
                    ['warehouse_id' => $defaultWarehouse->id],
                    ['current_stock' => $request->current_stock]
                );
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image_main) {
            Storage::disk('public')->delete($product->image_main);
        }
        
        // Also delete gallery images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->categories()->detach();
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Remove a specific product image from gallery.
     */
    public function destroyImage(Product $product, \App\Models\ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            abort(403);
        }

        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return back()->with('success', 'Image removed from gallery.');
    }
}
