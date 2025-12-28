<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display building wishlist page.
     */
    public function index()
    {
        $wishlistIds = session()->get('wishlist', []);
        $products = Product::whereIn('id', $wishlistIds)->with(['variants', 'categories'])->get();
        
        return view('web.wishlist', compact('products'));
    }

    /**
     * Toggle item in wishlist.
     */
    public function toggle(Request $request)
    {
        $productId = $request->product_id;
        $wishlist = session()->get('wishlist', []);

        if (($key = array_search($productId, $wishlist)) !== false) {
            unset($wishlist[$key]);
            $wishlist = array_values($wishlist);
            $action = 'removed';
            $message = 'Item removed from wishlist';
        } else {
            $wishlist[] = $productId;
            $action = 'added';
            $message = 'Item added to wishlist';
        }

        session()->put('wishlist', $wishlist);

        return response()->json([
            'success' => true,
            'action' => $action,
            'message' => $message,
            'count' => count($wishlist)
        ]);
    }

    /**
     * Remove item from wishlist.
     */
    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $wishlist = session()->get('wishlist', []);

        if (($key = array_search($productId, $wishlist)) !== false) {
            unset($wishlist[$key]);
            $wishlist = array_values($wishlist);
            session()->put('wishlist', $wishlist);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist',
            'count' => count($wishlist)
        ]);
    }
}
