<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Time Period Handling
        $period = $request->get('period', 'month'); // today, week, month, year, custom
        $startDate = null;
        $endDate = Carbon::now();

        switch ($period) {
            case 'today':
                $startDate = Carbon::today();
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                break;
            case 'custom':
                $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : Carbon::now()->subDays(30);
                $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : Carbon::now();
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
        }

        // Previous Period for Comparison
        $periodDiff = $startDate->diffInDays($endDate);
        $prevStartDate = $startDate->copy()->subDays($periodDiff + 1);
        $prevEndDate = $startDate->copy()->subDay();

        // 1. Revenue Metrics
        $totalRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');

        $prevRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->sum('total_price');

        $revenueTrend = $prevRevenue > 0 ? (($totalRevenue - $prevRevenue) / $prevRevenue) * 100 : 0;

        // 2. Orders Metrics
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $prevOrders = Order::whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();
        $ordersTrend = $prevOrders > 0 ? (($totalOrders - $prevOrders) / $prevOrders) * 100 : 0;

        // 3. Customer Analytics
        $newCustomers = DB::table('users')
            ->where('role', 'customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $returningCustomers = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('user', function($q) use ($startDate) {
                $q->whereHas('orders', function($q2) use ($startDate) {
                    $q2->where('created_at', '<', $startDate);
                });
            })
            ->distinct('user_id')
            ->count('user_id');

        // Average Order Value
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // 4. Operational Metrics
        $pendingShipments = Order::where('status', 'processing')->count();
        $lowStockItems = Stock::whereRaw('current_stock <= minimum_stock')->count();

        // 5. Revenue Chart Data (Daily breakdown)
        $revenueData = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 6. Top Selling Products
        $topProducts = OrderItem::whereBetween('created_at', [$startDate, $endDate])
            ->select('product_id', DB::raw('SUM(quantity) as total_sales'), DB::raw('SUM(price * quantity) as revenue'))
            ->groupBy('product_id')
            ->orderBy('revenue', 'desc')
            ->with('product')
            ->take(5)
            ->get();

        // 7. Sales by Category
        $categoryBreakdown = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_categories', 'products.id', '=', 'product_categories.product_id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->whereBetween('order_items.created_at', [$startDate, $endDate])
            ->select('categories.name', DB::raw('SUM(order_items.price * order_items.quantity) as total'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // 8. Recent Orders
        $recentOrders = Order::with('user', 'items.product')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'period',
            'startDate',
            'endDate',
            'totalRevenue',
            'revenueTrend',
            'totalOrders',
            'ordersTrend',
            'newCustomers',
            'returningCustomers',
            'avgOrderValue',
            'pendingShipments',
            'lowStockItems',
            'revenueData',
            'topProducts',
            'categoryBreakdown',
            'recentOrders'
        ));
    }
}
