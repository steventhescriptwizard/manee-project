<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the shop page.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with(['variants', 'categories']);

        // Filtering by Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtering by Category
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->whereHas('categories', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filtering by Color
        if ($request->filled('color')) {
            $color = $request->color;
            $query->whereHas('variants', function($q) use ($color) {
                $q->where('color', $color);
            });
        }

        // Filtering by Price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'alpha_asc':
                $query->orderBy('product_name', 'asc');
                break;
            case 'alpha_desc':
                $query->orderBy('product_name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        
        $categories = Category::whereNull('parent_id')->with('children')->get();
        // Colors from variants
        $colors = \App\Models\ProductVariant::distinct()->pluck('color')->filter()->values();

        return view('web.shop', compact('products', 'categories', 'colors'));
    }
}
