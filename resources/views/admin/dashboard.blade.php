@extends('layouts.admin')

@section('title', 'Dashboard - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6">
    <!-- Stats Section -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @include('components.admin.stats-card', [
            'title' => 'Total Revenue',
            'value' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
            'icon' => 'payments',
            'trend' => round($revenueTrend, 1),
            'trendLabel' => 'vs last month',
            'iconColorClass' => 'text-blue-600',
            'iconBgClass' => 'bg-blue-50 dark:bg-blue-900/30',
            'trendPositive' => $revenueTrend >= 0
        ])

        @include('components.admin.stats-card', [
            'title' => 'New Orders Today',
            'value' => $newOrdersCount,
            'icon' => 'shopping_cart',
            'trend' => 0,
            'trendLabel' => 'today',
            'iconColorClass' => 'text-purple-600',
            'iconBgClass' => 'bg-purple-100 dark:bg-purple-900/30',
            'trendPositive' => true
        ])

        @include('components.admin.stats-card', [
            'title' => 'Pending Shipments',
            'value' => $pendingShipments,
            'icon' => 'local_shipping',
            'trend' => 0,
            'trendLabel' => 'active',
            'iconColorClass' => 'text-orange-600',
            'iconBgClass' => 'bg-orange-100 dark:bg-orange-900/30',
            'trendPositive' => false
        ])

        @include('components.admin.stats-card', [
            'title' => 'Low Stock Items',
            'value' => $lowStockItems,
            'icon' => 'warning',
            'trend' => 0,
            'trendLabel' => 'critical',
            'iconColorClass' => 'text-red-600',
            'iconBgClass' => 'bg-red-100 dark:bg-red-900/30',
            'trendPositive' => false
        ])
    </section>

    <!-- Charts & Best Sellers -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @include('components.admin.revenue-chart', ['revenueData' => $revenueData])
        @include('components.admin.top-products', ['topProducts' => $topProducts])
    </div>

    <!-- Recent Orders -->
    @include('components.admin.recent-orders', ['recentOrders' => $recentOrders])
</div>
@endsection
