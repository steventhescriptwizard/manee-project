<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    public function index(Request $request)
    {
        $order = null;
        $orderNumber = $request->query('order_number');

        if ($orderNumber) {
            $order = Order::with(['items.product.images', 'shippingAddress'])
                ->where('order_number', $orderNumber)
                ->first();
                
            if (!$order) {
                return view('web.order-tracking', [
                    'order' => null,
                    'searched' => true,
                    'message' => 'Pesanan tidak ditemukan. Mohon periksa kembali nomor pesanan Anda.'
                ]);
            }
        }

        return view('web.order-tracking', [
            'order' => $order,
            'searched' => $orderNumber ? true : false,
        ]);
    }
}
