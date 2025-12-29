<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'is_published' => 'boolean',
            'is_verified' => 'boolean',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
}
