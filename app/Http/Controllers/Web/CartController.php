<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    /**
     * Display the cart page.
     */
    public function index()
    {
        $this->syncSessionToDb(); // Ensure DB is up to date

        $cart = $this->getCart();
        $newCart = [];
        $total = 0;

        $productIds = collect($cart)->pluck('id')->unique();
        $products = Product::with('taxes')->whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($cart as $key => $item) {
            $product = $products->get($item['id']);
            $price = $item['price']; // Base price
            
            if ($product) {
                // Calculate Tax Multiplier
                $taxMultiplier = 0;
                foreach ($product->taxes as $tax) {
                    if ($tax->is_active) {
                        $taxMultiplier += $tax->rate / 100;
                    }
                }
                
                // Calculate Final Price (Base + Tax)
                $finalPrice = $price * (1 + $taxMultiplier);
                
                $item['final_price'] = $finalPrice;
                $total += $finalPrice * $item['quantity'];
                
                // Update Image and Name if changed
                $item['name'] = $product->product_name;
                $item['image'] = $product->image_main;

            } else {
                 // Product might be deleted, handle gracefully (optional: remove from cart)
                 $item['final_price'] = $price;
                 $total += $price * $item['quantity'];
            }
            $newCart[$key] = $item;
        }

        return view('web.cart', ['cart' => $newCart, 'total' => $total]);
    }

    /**
     * Add a product/variant to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->product_id;
        $variantId = $request->variant_id;
        $quantity = $request->quantity;

        $product = Product::findOrFail($productId);
        $variant = $variantId ? ProductVariant::findOrFail($variantId) : null;

        $cartKey = $variantId ? "v{$variantId}" : "p{$productId}";
        
        // 1. Update Session Cart
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'id' => $productId,
                'variant_id' => $variantId,
                'name' => $product->product_name,
                'price' => $variant ? ($variant->price ?: $product->price) : $product->price,
                'quantity' => $quantity,
                'image' => $product->image_main,
                'color' => $variant ? $variant->color : null,
                'size' => $variant ? $variant->size : null,
            ];
        }

        session()->put('cart', $cart);

        // 2. Sync to DB if Logged In
        if (auth()->check()) {
            $this->syncSessionToDb();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'cart_count' => count($cart),
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            if (auth()->check()) {
                $this->syncSessionToDb();
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
                
                if (auth()->check()) {
                    $this->syncSessionToDb();
                }
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'cart_count' => count(session()->get('cart', []))]);
        }

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        session()->forget('cart');
        if (auth()->check()) {
            \App\Models\Cart::where('user_id', auth()->id())->delete();
        }
        return redirect()->back()->with('success', 'Cart cleared.');
    }

    /**
     * Helpers
     */
    private function getCart() {
        return session()->get('cart', []);
    }

    private function syncSessionToDb()
    {
        if (!auth()->check()) return;

        $user = auth()->user();
        $sessionCart = session()->get('cart', []);

        // Get or Create Cart
        $cart = \App\Models\Cart::firstOrCreate(['user_id' => $user->id]);
        
        // Touch timestamp to indicate activity
        $cart->touch(); 

        // Clear existing items (Simplest sync strategy: Replace all)
        // ideally we might want to merge, but replacing ensures exact state match
        $cart->items()->delete();

        foreach ($sessionCart as $key => $item) {
            $cart->items()->create([
                'product_id' => $item['id'],
                'product_variant_id' => $item['variant_id'] ?? null,
                'quantity' => $item['quantity'],
            ]);
        }
    }
}