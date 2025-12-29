<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return response()->json([
                'products' => [],
                'customers' => [],
                'orders' => []
            ]);
        }

        $results = [
            'products' => Product::where('product_name', 'like', '%' . $query . '%')
                ->orWhere('sku', 'like', '%' . $query . '%')
                ->limit(5)
                ->get()
                ->map(function ($product) {
                    return [
                        'type' => 'Product',
                        'label' => $product->product_name,
                        'sub' => 'SKU: ' . $product->sku,
                        'url' => route('admin.products.edit', $product->id),
                        'icon' => 'inventory_2'
                    ];
                }),
            'customers' => User::where('role', 'customer')
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%')
                      ->orWhere('email', 'like', '%' . $query . '%');
                })
                ->limit(5)
                ->get()
                ->map(function ($user) {
                    return [
                        'type' => 'Customer',
                        'label' => $user->name,
                        'sub' => $user->email,
                        'url' => route('admin.customers.show', $user->id),
                        'icon' => 'person'
                    ];
                }),
            'orders' => Order::where('order_number', 'like', '%' . $query . '%')
                ->limit(5)
                ->get()
                ->map(function ($order) {
                    return [
                        'type' => 'Order',
                        'label' => 'Order #' . $order->order_number,
                        'sub' => $order->created_at->format('d M Y'),
                        'url' => route('admin.orders.show', $order->id),
                        'icon' => 'shopping_bag'
                    ];
                }),
        ];

        return response()->json($results);
    }
}
