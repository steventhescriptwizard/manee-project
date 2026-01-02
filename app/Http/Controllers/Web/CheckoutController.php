<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $user = Auth::user();
        $addresses = $user->customer ? $user->customer->addresses : collect([]);
        
        $newCart = [];
        $total = 0;

        // Eager load products with taxes
        $productIds = collect($cart)->pluck('id')->unique();
        $products = \App\Models\Product::with('taxes')->whereIn('id', $productIds)->get()->keyBy('id');

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
            } else {
                 $item['final_price'] = $price;
                 $total += $price * $item['quantity'];
            }
            $newCart[$key] = $item;
        }

        return view('web.checkout', ['cart' => $newCart, 'total' => $total, 'addresses' => $addresses, 'user' => $user]);
    }

    /**
     * Process the order placement.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:customer_addresses,id',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
            'discount_code' => 'nullable|string|exists:discounts,code',
        ], [
            'shipping_address_id.required' => 'Pesanan membutuhkan alamat pengiriman, silahkan tambahkan alamat terlebih dahulu.',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = 0;
        $orderItems = [];
        $taxAmount = 0;

        foreach ($cart as $id => $item) {
            $lineTotal = $item['price'] * $item['quantity'];
            $subtotal += $lineTotal;

            // Calculate Tax for this item
            $product = \App\Models\Product::with('taxes')->find($item['id']);
            $itemTax = 0;
            if ($product) {
                foreach ($product->taxes as $tax) {
                    if ($tax->is_active) {
                        $itemTax += $lineTotal * ($tax->rate / 100);
                    }
                }
            }
            $taxAmount += $itemTax;
        }

        // Calculate Discount
        $discountAmount = 0;
        $discountCode = null;
        if ($request->filled('discount_code')) {
            $discount = \App\Models\Discount::where('code', $request->discount_code)->first();
            if ($discount) {
                $calculatedDiscount = $discount->calculateDiscount($cart);
                
                if ($calculatedDiscount > 0) {
                    $discountCode = $discount->code;
                    $discountAmount = $calculatedDiscount;
                    $discount->increment('usage_count');
                }
            }
        }

        $totalPrice = $subtotal - $discountAmount + $taxAmount;

        try {
            DB::beginTransaction();

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice, // Final total
                'subtotal' => $subtotal,
                'discount_code' => $discountCode,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'status' => 'pending',
                'shipping_address_id' => $request->shipping_address_id,
                'shipping_method' => $request->shipping_method,
                'payment_method' => 'Midtrans',
                'payment_status' => 'unpaid',
                'notes' => $request->notes,
            ]);

             // Create Order Items and Update Stock
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_variant_id' => $item['variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update Stock (Simple logic: take from first available warehouse or just decrement stock)
                $stock = Stock::where('product_id', $item['id'])
                    ->when(isset($item['variant_id']), function($query) use ($item) {
                        return $query->where('variant_id', $item['variant_id']);
                    })
                    ->first();

                if ($stock) {
                    $stock->decrement('current_stock', $item['quantity']);
                    $stock->increment('stock_out', $item['quantity']);

                    // Record Movement
                    StockMovement::create([
                        'product_id' => $item['id'],
                        'variant_id' => $item['variant_id'] ?? null,
                        'warehouse_id' => $stock->warehouse_id,
                        'type' => 'OUT',
                        'quantity' => $item['quantity'],
                        'reference_type' => 'order',
                        'reference_id' => $order->id,
                        'notes' => 'Order ' . $order->order_number,
                    ]);
                }
            }

            DB::commit();

            // Midtrans Integration
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            $itemDetails = collect($cart)->map(function ($item) {
                return [
                    'id' => $item['id'] ?? 'PROD-' . rand(100, 999),
                    'price' => (int) $item['price'],
                    'quantity' => (int) $item['quantity'],
                    'name' => substr($item['name'] ?? 'Product Item', 0, 50),
                ];
            })->values()->toArray();

            // Add Tax Item if > 0
            if ($taxAmount > 0) {
                $itemDetails[] = [
                    'id' => 'TAX',
                    'price' => (int) $taxAmount,
                    'quantity' => 1,
                    'name' => 'Tax / PPN',
                ];
            }

            // Add Discount Item if > 0 (Negative price)
            if ($discountAmount > 0) {
                $itemDetails[] = [
                    'id' => 'DISC',
                    'price' => (int) -$discountAmount,
                    'quantity' => 1,
                    'name' => 'Discount (' . $discountCode . ')',
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int) $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->customer?->phone ?? '',
                ],
                'item_details' => $itemDetails,
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            // Notify Admins
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new NewOrderNotification($order, Auth::user()->name));
            
            // Notify Customer
            Auth::user()->notify(new \App\Notifications\CustomerOrderCreateNotification($order));

            // Clear Cart
            session()->forget('cart');
            
            // Store order number in session for order success page
            session()->put('order_number', $order->order_number);
            session()->save(); // Force save session before AJAX response
            
            Log::info('Order created', [
                'order_number' => $order->order_number,
                'session_order_number' => session('order_number'),
                'redirect_url' => route('order.success')
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'snap_token' => $snapToken,
                    'order_number' => $order->order_number,
                    'redirect_url' => route('order.success')
                ]);
            }

            return redirect()->route('order.success');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ], 500);
            }
            
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda: ' . $e->getMessage());
        }
    }

    public function checkDiscount(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = \App\Models\Discount::where('code', $request->code)->first();

        if (!$discount) {
            return response()->json(['valid' => false, 'message' => 'Invalid discount code.'], 404);
        }

        $discountAmount = $discount->calculateDiscount($cart);

        if ($discountAmount <= 0) {
             $message = 'Discount criteria not met.';
             if ($discount->minimum_purchase && $subtotal < $discount->minimum_purchase) {
                $message = 'Minimum purchase of Rp ' . number_format($discount->minimum_purchase, 0, ',', '.') . ' required.';
             } else {
                 $message = 'This discount does not apply to the items in your cart.';
             }
             return response()->json(['valid' => false, 'message' => $message], 422);
        }

        // Calculate tax for preview
        $taxAmount = 0;
        foreach ($cart as $item) {
            $product = \App\Models\Product::with('taxes')->find($item['id']);
             if ($product) {
                foreach ($product->taxes as $tax) {
                    if ($tax->is_active) {
                        $taxAmount += ($item['price'] * $item['quantity']) * ($tax->rate / 100);
                    }
                }
            }
        }

        $newTotal = $subtotal - $discountAmount + $taxAmount;

        return response()->json([
            'valid' => true,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'new_total' => $newTotal,
            'message' => 'Discount applied successfully!'
        ]);
    }
}
