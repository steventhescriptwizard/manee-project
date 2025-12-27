@extends('layouts.admin')

@section('title', 'Dashboard - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6">
    <!-- Stats Section -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @include('components.admin.stats-card', [
            'title' => 'Total Revenue',
            'value' => '$12,450',
            'icon' => 'payments',
            'trend' => 12,
            'trendLabel' => 'vs last week',
            'iconColorClass' => 'text-blue-600',
            'iconBgClass' => 'bg-blue-50 dark:bg-blue-900/30',
            'trendPositive' => true
        ])

        @include('components.admin.stats-card', [
            'title' => 'New Orders',
            'value' => '45',
            'icon' => 'shopping_cart',
            'trend' => 5,
            'trendLabel' => 'vs last week',
            'iconColorClass' => 'text-purple-600',
            'iconBgClass' => 'bg-purple-100 dark:bg-purple-900/30',
            'trendPositive' => true
        ])

        @include('components.admin.stats-card', [
            'title' => 'Pending Shipments',
            'value' => '12',
            'icon' => 'local_shipping',
            'trend' => 2,
            'trendLabel' => 'vs last week',
            'iconColorClass' => 'text-orange-600',
            'iconBgClass' => 'bg-orange-100 dark:bg-orange-900/30',
            'trendPositive' => false
        ])

        @include('components.admin.stats-card', [
            'title' => 'Low Stock Items',
            'value' => '5',
            'icon' => 'warning',
            'trend' => 0,
            'trendLabel' => 'vs last week',
            'iconColorClass' => 'text-red-600',
            'iconBgClass' => 'bg-red-100 dark:bg-red-900/30',
            'trendPositive' => false
        ])
    </section>

    <!-- Placeholder for Charts & Tables -->
    <!-- Charts & Best Sellers -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @include('components.admin.revenue-chart')
        @include('components.admin.top-products')
    </div>

    <!-- Recent Orders -->
    @include('components.admin.recent-orders')
</div>
@endsection
