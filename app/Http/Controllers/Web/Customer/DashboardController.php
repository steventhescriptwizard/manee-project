<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recommendedProducts = Product::inRandomOrder()->take(3)->get();

        return view('web.customer.dashboard', compact('user', 'recentOrders', 'recommendedProducts'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->get();
            
        return view('web.customer.orders', compact('user', 'orders'));
    }

    public function showOrder($id)
    {
        $user = Auth::user();
        $order = Order::with(['items.product', 'items.variant', 'shippingAddress'])
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('web.customer.orders.show', compact('user', 'order'));
    }

    public function addresses()
    {
        $user = Auth::user();
        return view('web.customer.address', compact('user'));
    }

    public function payments()
    {
        $user = Auth::user();
        return view('web.customer.payment', compact('user'));
    }

    public function wishlist()
    {
        $user = Auth::user();
        // Assuming there's a relationship or we fetch from Wishlist model
        return redirect()->route('wishlist'); // For now redirect to the global wishlist page
    }

    public function completeOrder($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // Only allow completion if order is shipped or out for delivery
        if (!in_array($order->status, ['shipped', 'out_for_delivery'])) {
            return redirect()->back()->with('error', 'Pesanan tidak dapat ditandai sebagai diterima pada status saat ini.');
        }

        $order->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Pesanan telah ditandai sebagai diterima. Terima kasih!');
    }
}
