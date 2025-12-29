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
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

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
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('web.checkout', compact('cart', 'total', 'addresses', 'user'));
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
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        try {
            DB::beginTransaction();

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'shipping_address_id' => $request->shipping_address_id,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
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

            // Notify Admins
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new NewOrderNotification($order, Auth::user()->name));

            // Clear Cart
            session()->forget('cart');

            return redirect()->route('order.success')->with('order_number', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda: ' . $e->getMessage());
        }
    }
}
