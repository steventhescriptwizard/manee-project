<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OutstandingController extends Controller
{
    public function index(Request $request)
    {
        $timeRange = $request->get('range', 'Hari Ini');
        $categoryId = $request->get('category', 'all');

        // Base Query
        $orderQuery = Order::query();

        // Filter by Category
        if ($categoryId !== 'all') {
            $orderQuery->whereHas('items.product.categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        // --- STATS CALCULATION ---
        
        // 1. Total Sales (Revenue) - Filtered by Range
        $salesQuery = clone $orderQuery;
        $this->applyDateFilter($salesQuery, $timeRange);
        $totalSales = $salesQuery->where('payment_status', 'paid')->sum('total_price');

        // Compare with previous period (Simple logic: yesterday vs today for 'Hari Ini')
        $prevSalesQuery = clone $orderQuery;
        // For simplicity in this iteration, just fetching current stats. 
        // Real comparison logic would require more complex date handling.
        
        // 2. Total Orders
        $ordersCountQuery = clone $orderQuery;
        $this->applyDateFilter($ordersCountQuery, $timeRange);
        $totalOrders = $ordersCountQuery->count();

        // 3. Average Order Value
        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // 4. Outstanding Orders (Status NOT completed/cancelled)
        // This is usually ALL TIME outstanding, not just 'today's outstanding', but let's respect the category filter
        $outstandingQuery = Order::query()
            ->whereNotIn('status', ['completed', 'cancelled']);
            
        if ($categoryId !== 'all') {
             $outstandingQuery->whereHas('items.product.categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }
        $outstandingCount = $outstandingQuery->count();


        // --- CHART DATA ---
        // Sales Trend (Last 7 days or current month)
        $chartData = $this->getSalesChartData($categoryId);

        // Donut Data (Outstanding Status Distribution)
        $donutStats = (clone $outstandingQuery)->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $donutData = [
            'pending' => $donutStats['pending'] ?? 0,
            'processing' => $donutStats['processing'] ?? 0,
            'shipped' => $donutStats['shipped'] ?? 0, // 'shipped' + 'out_for_delivery'
        ];
        // Merge similar statuses if needed
        if (isset($donutStats['out_for_delivery'])) {
            $donutData['shipped'] += $donutStats['out_for_delivery'];
        }

        // --- TABLE DATA ---
        $outstandingOrders = $outstandingQuery->with('user')->latest()->take(10)->get();

        // --- DATA FOR VIEW ---
        $categories = Category::all();

        return view('admin.outstanding.index', compact(
            'totalSales', 'totalOrders', 'avgOrderValue', 'outstandingCount',
            'chartData', 'donutData', 'outstandingOrders', 'categories',
            'timeRange', 'categoryId'
        ));
    }

    private function applyDateFilter($query, $range)
    {
        switch ($range) {
            case 'Hari Ini':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'Minggu Ini':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'Bulan Ini':
                $query->whereMonth('created_at', Carbon::now()->month);
                break;
            case 'Tahun Ini':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }
    }

    private function getSalesChartData($categoryId)
    {
        // Get last 7 days sales
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(Carbon::now()->subDays($i)->format('Y-m-d'));
        }

        $query = Order::where('payment_status', 'paid')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(6));

        if ($categoryId !== 'all') {
            $query->whereHas('items.product.categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        $sales = $query->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
            ->groupBy('date')
            ->pluck('total', 'date');

        $data = $dates->map(function ($date) use ($sales) {
            return [
                'date' => Carbon::parse($date)->format('d M'),
                'value' => $sales[$date] ?? 0
            ];
        });

        return $data;
    }
}
