@extends('layouts.admin')

@section('title', 'Order Management - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6">
    
    {{-- Breadcrumbs & Title & Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-slate-900 dark:text-white font-medium">Orders</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Order Management</h1>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[20px]">file_download</span>
                Export
            </button>
            <button class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors shadow-sm shadow-blue-200 dark:shadow-none">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Create Order
            </button>
        </div>
    </div>

    {{-- Stats Grid (Optional, but included in ref) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @include('components.admin.stats-card', [
            'title' => 'Total Orders',
            'value' => $orders->total(),
            'icon' => 'shopping_cart',
            'trend' => 8,
            'trendLabel' => 'vs last month',
            'iconColorClass' => 'text-blue-600',
            'iconBgClass' => 'bg-blue-50 dark:bg-blue-900/30',
            'trendPositive' => true
        ])
        @include('components.admin.stats-card', [
            'title' => 'Pending',
            'value' => $orders->where('status', 'pending')->count(),
            'icon' => 'pending',
            'trend' => 12,
            'trendLabel' => 'vs last month',
            'iconColorClass' => 'text-amber-600',
            'iconBgClass' => 'bg-amber-50 dark:bg-amber-900/30',
            'trendPositive' => false
        ])
        @include('components.admin.stats-card', [
            'title' => 'Monthly Revenue',
            'value' => 'Rp ' . number_format($orders->where('payment_status', 'paid')->sum('total_price'), 0, ',', '.'),
            'icon' => 'payments',
            'trend' => 15,
            'trendLabel' => 'vs last month',
            'iconColorClass' => 'text-green-600',
            'iconBgClass' => 'bg-green-50 dark:bg-green-900/30',
            'trendPositive' => true
        ])
        @include('components.admin.stats-card', [
            'title' => 'Completed',
            'value' => $orders->where('status', 'completed')->count(),
            'icon' => 'task_alt',
            'trend' => 20,
            'trendLabel' => 'vs last month',
            'iconColorClass' => 'text-purple-600',
            'iconBgClass' => 'bg-purple-100 dark:bg-purple-900/30',
            'trendPositive' => true
        ])
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-slate-200 dark:border-gray-700 shadow-sm p-4">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center">
            {{-- Search --}}
            <div class="relative w-full lg:w-96">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    search
                </span>
                <input
                    name="search"
                    value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 h-10 bg-slate-50 dark:bg-gray-900/50 border border-slate-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 text-slate-900 dark:text-white placeholder:text-slate-400 transition-all outline-none"
                    placeholder="Search by Order ID or Customer Name"
                    type="text"
                />
            </div>

            {{-- Filters --}}
            <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                <div class="relative group">
                    <select name="status" onchange="this.form.submit()" class="appearance-none h-10 pl-3 pr-8 bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/20 cursor-pointer hover:border-slate-300 dark:hover:border-gray-600 transition-colors">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Status: All</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[20px]">
                        expand_more
                    </span>
                </div>
                <div class="relative group">
                    <select name="payment_status" onchange="this.form.submit()" class="appearance-none h-10 pl-3 pr-8 bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/20 cursor-pointer hover:border-slate-300 dark:hover:border-gray-600 transition-colors">
                        <option value="all" {{ request('payment_status') == 'all' ? 'selected' : '' }}>Payment: All</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[20px]">
                        expand_more
                    </span>
                </div>
                <button type="submit" class="h-10 px-4 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Search
                </button>
                @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to', 'payment_method']))
                    <a href="{{ route('admin.orders.index') }}" class="h-10 px-4 bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-slate-400 rounded-lg text-sm font-medium hover:bg-slate-200 dark:hover:bg-gray-600 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-slate-200 dark:border-gray-700 shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 dark:bg-gray-700/50 border-b border-slate-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-slate-900 dark:text-white w-10">
                            <input
                                type="checkbox"
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-600/20 size-4 cursor-pointer"
                            />
                        </th>
                        <th class="px-6 py-4 font-semibold text-slate-900 dark:text-white">Order ID</th>
                        <th class="px-6 py-4 font-semibold text-slate-900 dark:text-white">Date</th>
                        <th class="px-6 py-4 font-semibold text-slate-900 dark:text-white">Customer</th>
                        <th class="px-6 py-4 font-semibold text-slate-900 dark:text-white">Total</th>
                        <th class="px-6 py-4 font-semibold text-slate-900 dark:text-white">Payment</th>
                        <th class="px-6 py-4 font-semibold text-slate-900 dark:text-white">Status</th>
                        <th class="px-6 py-4 font-semibold text-slate-900 dark:text-white text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                    @foreach($orders as $order)
                        <tr class="hover:bg-slate-50 dark:hover:bg-gray-700/30 transition-colors group">
                            <td class="px-6 py-4">
                                <input
                                    type="checkbox"
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-600/20 size-4 cursor-pointer"
                                />
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 font-medium hover:underline">
                                    #{{ $order->order_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                {{ $order->created_at->format('d M Y') }} <span class="text-xs text-slate-400 ml-1">{{ $order->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($order->user->name, 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-slate-900 dark:text-white font-medium">
                                            {{ $order->user->name }}
                                        </span>
                                        <span class="text-xs text-slate-500">{{ $order->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium 
                                    {{ $order->payment_status === 'paid' ? 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-100' : 'bg-slate-100 text-slate-600 dark:bg-gray-700' }}">
                                    <span class="size-1.5 rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-500' : 'bg-slate-400' }}"></span>
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'processing' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        'shipped' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                        'completed' => 'bg-green-50 text-green-700 border-green-100',
                                        'cancelled' => 'bg-red-50 text-red-700 border-red-100',
                                    ];
                                    $statusClass = $statusClasses[$order->status] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="View Details">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                    <button class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="Print Invoice">
                                        <span class="material-symbols-outlined text-[20px]">print</span>
                                    </button>
                                    <button class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="More Actions">
                                        <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-slate-200 dark:border-gray-700">
            {{ $orders->links() }}
        </div>
    </div>

    {{-- Footer --}}
    <footer class="mt-8 mb-4 text-center text-sm text-slate-400">
        © {{ date('Y') }} Maneé Clothing. All rights reserved.
    </footer>
</div>
@endsection
