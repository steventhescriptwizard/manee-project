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
    public function index(Request $request)
    {
        $query = Product::with('categories');

        // Search by Product Name or SKU
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Filter by Stock Status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->whereHas('stocks', function($q) {
                    $q->whereRaw('current_stock <= 10');
                });
            } elseif ($request->stock_status === 'out') {
                $query->whereHas('stocks', function($q) {
                    $q->where('current_stock', 0);
                });
            }
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        // Get all categories for filter dropdown
        $categories = \App\Models\Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $taxes = \App\Models\Tax::where('is_active', true)->get();
        return view('admin.products.create', compact('categories', 'taxes'));
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

        if ($request->has('taxes')) {
            $product->taxes()->attach($request->taxes);
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
        $product->load(['categories', 'images', 'variants', 'stocks.warehouse', 'taxes']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['categories', 'taxes']);
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $taxes = \App\Models\Tax::all();
        return view('admin.products.edit', compact('product', 'categories', 'taxes'));
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

        if ($request->has('taxes')) {
            $product->taxes()->sync($request->taxes);
        } else {
            $product->taxes()->detach();
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
        $product->taxes()->detach();
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
