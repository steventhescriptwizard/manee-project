<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch top-level categories for the home page sections
        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->take(3)
            ->get();

        // Fetch products for the slider
        $products = Product::with('categories')->latest()->take(10)->get();

        return view('web.home', compact('categories', 'products'));
    }
}
