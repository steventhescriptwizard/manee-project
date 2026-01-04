@extends('layouts.admin')

@section('title', 'Laporan Penjualan & Outstanding - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6" x-data="outstandingPage()">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-slate-900 dark:text-white text-2xl md:text-3xl font-black leading-tight tracking-tight">
                Laporan Penjualan
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-normal">
                Analisis performa toko dan pantau status pesanan outstanding
            </p>
        </div>
        
        <div class="flex items-center gap-3 flex-wrap sm:flex-nowrap">
            <!-- Category Dropdown -->
            <form id="filterForm" method="GET" action="{{ route('admin.outstanding.index') }}">
                <input type="hidden" name="range" :value="activeRange">
                <div class="relative group">
                    <select name="category" onchange="this.form.submit()" class="appearance-none cursor-pointer flex items-center justify-between gap-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 h-10 pl-4 pr-10 text-sm font-semibold transition-colors focus:ring-2 focus:ring-blue-500 focus:outline-none w-full sm:w-auto">
                        <option value="all" {{ $categoryId == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined text-[20px]">expand_more</span>
                    </div>
                </div>
            </form>

            <!-- Export Button (Mockup) -->
            <button type="button" class="flex items-center justify-center gap-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white h-10 px-4 text-sm font-bold shadow-sm transition-colors">
                <span class="material-symbols-outlined text-[20px]">download</span>
                <span>Export Data</span>
            </button>
        </div>
    </div>

    <!-- Time Range Tabs -->
    <div class="flex gap-2 overflow-x-auto pb-1 no-scrollbar">
        @foreach(['Hari Ini', 'Minggu Ini', 'Bulan Ini', 'Tahun Ini'] as $range)
            <a href="{{ route('admin.outstanding.index', ['range' => $range, 'category' => $categoryId]) }}"
               class="flex h-8 shrink-0 items-center justify-center rounded-full px-4 text-sm font-medium transition-all {{ $timeRange === $range ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                {{ $range }}
            </a>
        @endforeach
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Sales -->
        <div class="bg-white dark:bg-gray-900 p-5 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm flex flex-col gap-1">
            <div class="flex justify-between items-start">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Penjualan</p>
                <div class="bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400 text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    <span>12%</span>
                </div>
            </div>
            <p class="text-slate-900 dark:text-white text-2xl font-bold tracking-tight">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            <p class="text-slate-400 text-xs">vs. Periode Sebelumnya</p>
        </div>

        <!-- Total Orders -->
        <div class="bg-white dark:bg-gray-900 p-5 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm flex flex-col gap-1">
            <div class="flex justify-between items-start">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Pesanan</p>
                <div class="bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400 text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    <span>5%</span>
                </div>
            </div>
            <p class="text-slate-900 dark:text-white text-2xl font-bold tracking-tight">{{ number_format($totalOrders, 0, ',', '.') }}</p>
            <p class="text-slate-400 text-xs">vs. Periode Sebelumnya</p>
        </div>

        <!-- Avg Order Value -->
        <div class="bg-white dark:bg-gray-900 p-5 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm flex flex-col gap-1">
            <div class="flex justify-between items-start">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Rata-rata Order</p>
                <div class="bg-orange-50 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400 text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">trending_down</span>
                    <span>2%</span>
                </div>
            </div>
            <p class="text-slate-900 dark:text-white text-2xl font-bold tracking-tight">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</p>
            <p class="text-slate-400 text-xs">vs. Periode Sebelumnya</p>
        </div>

        <!-- Outstanding -->
        <div class="bg-white dark:bg-gray-900 p-5 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm flex flex-col gap-1 ring-1 ring-orange-100 dark:ring-orange-900/30">
            <div class="flex justify-between items-start">
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Outstanding</p>
                <div class="bg-orange-50 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400 text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                    <span>Perlu Tindakan</span>
                </div>
            </div>
            <p class="text-slate-900 dark:text-white text-2xl font-bold tracking-tight">{{ $outstandingCount }}</p>
            <p class="text-slate-400 text-xs">Pesanan belum selesai</p>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-slate-900 dark:text-white text-lg font-bold">Trend Penjualan</h3>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                <span>{{ $timeRange }}</span>
            </div>
        </div>
        <div id="salesChart" class="w-full h-[300px]"></div>
    </div>

    <!-- Bottom Grid: Donut + Table -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Outstanding Chart -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm flex flex-col">
            <h3 class="text-slate-900 dark:text-white text-lg font-bold mb-4">Status Pesanan</h3>
            <div class="flex-1 flex max-h-[300px] justify-center items-center">
                <div id="outstandingChart" class="w-full"></div>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1 p-3 rounded-lg bg-amber-50 dark:bg-amber-900/20">
                    <span class="text-xs text-amber-700 dark:text-amber-400 font-medium">Menunggu Bayar</span>
                    <span class="text-lg font-bold text-amber-800 dark:text-amber-300">{{ $donutData['pending'] }}</span>
                </div>
                <div class="flex flex-col gap-1 p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                    <span class="text-xs text-blue-700 dark:text-blue-400 font-medium">Sedang Diproses</span>
                    <span class="text-lg font-bold text-blue-800 dark:text-blue-300">{{ $donutData['processing'] }}</span>
                </div>
                 <div class="flex flex-col gap-1 p-3 rounded-lg bg-red-50 dark:bg-red-900/20 col-span-2">
                    <span class="text-xs text-red-700 dark:text-red-400 font-medium">Perlu Pengiriman</span>
                    <span class="text-lg font-bold text-red-800 dark:text-red-300">{{ $donutData['shipped'] }}</span>
                </div>
            </div>
        </div>

        <!-- Order Table -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden flex flex-col h-full">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                <h3 class="text-slate-900 dark:text-white text-lg font-bold">Daftar Outstanding</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 text-sm font-semibold hover:underline cursor-pointer">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 font-medium">
                        <tr>
                            <th class="px-6 py-3 whitespace-nowrap">Order ID</th>
                            <th class="px-6 py-3 whitespace-nowrap">Pelanggan</th>
                            <th class="px-6 py-3 whitespace-nowrap">Status</th>
                            <th class="px-6 py-3 whitespace-nowrap">Total</th>
                            <th class="px-6 py-3 whitespace-nowrap text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($outstandingOrders as $order)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $order->order_number }}</td>
                            <td class="px-6 py-4">
                                <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $order->user->name ?? 'Guest' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($order->status) {
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-900/50',
                                        'processing' => 'bg-blue-50 text-blue-600 border-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-900/50',
                                        'shipped', 'out_for_delivery' => 'bg-red-50 text-red-600 border-red-100 dark:bg-red-900/30 dark:text-red-400 dark:border-red-900/50',
                                        default => 'bg-slate-50 text-slate-600 border-slate-100'
                                    };
                                    $dotClass = match($order->status) {
                                        'pending' => 'bg-amber-500',
                                        'processing' => 'bg-blue-600',
                                        'shipped', 'out_for_delivery' => 'bg-red-500',
                                        default => 'bg-slate-500'
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }} {{ $order->status === 'pending' ? 'animate-pulse' : '' }}"></span>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors p-1 rounded hover:bg-slate-100 dark:hover:bg-slate-800">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">Tidak ada order outstanding.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ApexCharts --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function outstandingPage() {
        return {
            activeRange: '{{ $timeRange }}',
        };
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Sales Chart
        const salesOptions = {
            series: [{
                name: 'Penjualan',
                data: @json($chartData->pluck('value')->toArray())
            }],
            chart: {
                height: 300,
                type: 'area',
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            xaxis: {
                categories: @json($chartData->pluck('date')->toArray()),
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#94a3b8', fontSize: '12px' } }
            },
            yaxis: {
                labels: {
                    style: { colors: '#94a3b8', fontSize: '12px' },
                    formatter: (value) => { return 'Rp ' + (value / 1000000).toFixed(1) + 'jt' }
                }
            },
            colors: ['#3b82f6'],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
            },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            tooltip: {
                y: { formatter: function (val) { return "Rp " + val.toLocaleString('id-ID') } }
            }
        };

        const salesChart = new ApexCharts(document.querySelector("#salesChart"), salesOptions);
        salesChart.render();

        // Outstanding Donut Chart
        const donutOptions = {
            series: [{{ $donutData['pending'] }}, {{ $donutData['processing'] }}, {{ $donutData['shipped'] }}],
            labels: ['Menunggu Bayar', 'Sedang Diproses', 'Perlu Pengiriman'],
            chart: {
                type: 'donut',
                height: 320,
                fontFamily: 'Inter, sans-serif',
            },
            colors: ['#fbbf24', '#3b82f6', '#ef4444'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Outstanding',
                                fontSize: '14px',
                                fontWeight: 600,
                                color: '#64748b',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            },
                            value: {
                                fontSize: '24px',
                                fontWeight: 'bold',
                                color: '#0f172a',
                            }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: { position: 'bottom', horizontalAlign: 'center' },
            stroke: { show: false }
        };

        const donutChart = new ApexCharts(document.querySelector("#outstandingChart"), donutOptions);
        donutChart.render();
    });
</script>
@endsection
