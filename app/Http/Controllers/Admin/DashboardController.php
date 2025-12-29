<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Overview Stats
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');
        $newOrdersCount = Order::whereDate('created_at', Carbon::today())->count();
        $pendingShipments = Order::where('status', 'processing')->count();
        $lowStockItems = Stock::where('current_stock', '<=', DB::raw('minimum_stock'))->count();

        // Trends (Mocking trends for now, or calculating vs last week if data exists)
        $lastWeekRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [Carbon::now()->subWeeks(2), Carbon::now()->subWeek()])
            ->sum('total_price');
        $revenueTrend = $lastWeekRevenue > 0 ? (($totalRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100 : 0;

        // 2. Revenue Analytics (Last 30 Days)
        $revenueData = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 3. Top Selling Products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderBy('total_sales', 'desc')
            ->with('product')
            ->take(5)
            ->get();

        // 4. Recent Orders
        $recentOrders = Order::with('user', 'items.product')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'newOrdersCount',
            'pendingShipments',
            'lowStockItems',
            'revenueTrend',
            'revenueData',
            'topProducts',
            'recentOrders'
        ));
    }
}
