<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['categories', 'images', 'variants', 'variants.stocks', 'reviews.user', 'reviews.images'])->findOrFail($id);
        
        // Extract unique colors and sizes from variants
        $colors = $product->variants->pluck('color')->filter()->unique();
        $sizes = $product->variants->pluck('size')->filter()->unique();

        // Multi-currency calculation (1 USD = 15,500 IDR)
        $exchangeRate = 15500;
        $priceUsd = $product->price / $exchangeRate;

        // Fetch related products
        $categoryIds = $product->categories->pluck('id');
        $relatedProducts = Product::whereHas('categories', function($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        })->where('id', '!=', $id)->take(4)->get();

        return view('web.products.show', compact('product', 'relatedProducts', 'colors', 'sizes', 'priceUsd'));
    }
}
