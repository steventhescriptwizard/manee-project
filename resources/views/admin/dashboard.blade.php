@extends('layouts.admin')

@php
    $breadcrumbs = [];
@endphp

@section('title', 'Dashboard - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6" x-data="{ showCustom: {{ $period === 'custom' ? 'true' : 'false' }} }">
    <!-- Period Filter -->
    <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm">
        <form method="GET" class="flex flex-wrap gap-3 items-end" id="periodFilter">
            <div class="flex-1 min-w-[200px]">
                <label class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1 block">Time Period</label>
                <select name="period" @change="if($event.target.value === 'custom') { showCustom = true; } else { window.location.href = '{{ route('admin.dashboard') }}?period=' + $event.target.value; }" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                    <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ $period === 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="year" {{ $period === 'year' ? 'selected' : '' }}>This Year</option>
                    <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>
            
            <div x-show="showCustom" x-cloak class="flex gap-2 flex-1">
                <div class="flex-1">
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1 block">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date', $startDate->format('Y-m-d')) }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                </div>
                <div class="flex-1">
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1 block">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date', $endDate->format('Y-m-d')) }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors self-end">
                    Apply
                </button>
            </div>
        </form>
    </div>

    <!-- Stats Section -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @include('components.admin.stats-card', [
            'title' => 'Total Revenue',
            'value' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
            'icon' => 'payments',
            'trend' => round($revenueTrend, 1),
            'trendLabel' => 'vs previous period',
            'iconColorClass' => 'text-blue-600',
            'iconBgClass' => 'bg-blue-50 dark:bg-blue-900/30',
            'trendPositive' => $revenueTrend >= 0
        ])

        @include('components.admin.stats-card', [
            'title' => 'Total Orders',
            'value' => $totalOrders,
            'icon' => 'shopping_cart',
            'trend' => round($ordersTrend, 1),
            'trendLabel' => 'vs previous period',
            'iconColorClass' => 'text-purple-600',
            'iconBgClass' => 'bg-purple-100 dark:bg-purple-900/30',
            'trendPositive' => $ordersTrend >= 0
        ])

        @include('components.admin.stats-card', [
            'title' => 'Avg Order Value',
            'value' => 'Rp ' . number_format($avgOrderValue, 0, ',', '.'),
            'icon' => 'trending_up',
            'trend' => 0,
            'trendLabel' => 'per order',
            'iconColorClass' => 'text-green-600',
            'iconBgClass' => 'bg-green-100 dark:bg-green-900/30',
            'trendPositive' => true
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

    <!-- Customer Analytics -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">New Customers</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $newCustomers }}</p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600">person_add</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Returning Customers</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $returningCustomers }}</p>
                </div>
                <div class="bg-purple-50 dark:bg-purple-900/30 p-3 rounded-lg">
                    <span class="material-symbols-outlined text-purple-600">repeat</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Pending Shipments</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $pendingShipments }}</p>
                </div>
                <div class="bg-orange-50 dark:bg-orange-900/30 p-3 rounded-lg">
                    <span class="material-symbols-outlined text-orange-600">local_shipping</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts & Best Sellers -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @include('components.admin.revenue-chart', ['revenueData' => $revenueData, 'revenueTrend' => $revenueTrend])
        @include('components.admin.top-products', ['topProducts' => $topProducts])
    </div>

    <!-- Category Breakdown & Recent Orders -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @include('components.admin.category-breakdown', ['categoryBreakdown' => $categoryBreakdown])
        <div>
            @include('components.admin.recent-orders', ['recentOrders' => $recentOrders])
        </div>
    </div>
</div>
@endsection
