<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product', 'images'])->where('is_published', true);

        // Filtering
        if ($request->has('rating') && $request->rating != 'all') {
            $query->where('rating', $request->rating);
        }

        if ($request->has('filter')) {
            if ($request->filter === 'with_photo') {
                $query->whereHas('images');
            } elseif ($request->filter === 'verified') {
                $query->where('is_verified', true);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        if ($sort === 'highest') {
            $query->orderBy('rating', 'desc');
        } elseif ($sort === 'lowest') {
            $query->orderBy('rating', 'asc');
        } else {
            $query->latest();
        }

        $reviews = $query->paginate(10)->withQueryString();

        // Calculate Stats
        $allReviews = Review::where('is_published', true)->get();
        $totalCount = $allReviews->count();
        $averageRating = number_format($allReviews->avg('rating') ?: 0, 1);
        
        $stats = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $allReviews->where('rating', $i)->count();
            $percentage = $totalCount > 0 ? round(($count / $totalCount) * 100) : 0;
            $stats[] = [
                'star' => $i,
                'count' => $count,
                'percentage' => $percentage,
                'color' => $i >= 4 ? 'bg-brandBlue' : 'bg-gray-400'
            ];
        }

        // Handle order_id parameter for review form pre-fill
        $orderProducts = null;
        if ($request->has('order_id')) {
            $order = \App\Models\Order::with('items.product')
                ->where('id', $request->order_id)
                ->where('user_id', auth()->id())
                ->first();
            
            if ($order) {
                $orderProducts = $order->items->pluck('product')->unique('id');
            }
        }

        return view('web.reviews.index', compact('reviews', 'stats', 'totalCount', 'averageRating', 'orderProducts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|min:10',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $review = Review::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_verified' => false, // Set to true if they actually bought it (logic to be added later if needed)
            'is_published' => true,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');
                $review->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return back()->with('success', 'Thank you for your review!');
    }
}
