<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display products for a specific category.
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = $category->products()
            ->with(['images', 'variants'])
            ->latest()
            ->paginate(12);

        // Map slug to hero image
        $heroImages = [
            'knitwear' => '/images/category-knitwear.png',
            'tops' => '/images/category-tops.png',
            'bottoms' => '/images/category-bottoms.png',
        ];

        $heroImage = $heroImages[$slug] ?? '/images/hero.png';

        return view('web.categories.show', compact('category', 'products', 'heroImage'));
    }
}
