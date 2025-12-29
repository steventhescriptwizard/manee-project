<div class="lg:col-span-2 bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Revenue Analytics</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Overview of revenue for the last 30 days</p>
        </div>
        <button class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-gray-800 rounded-lg hover:bg-slate-200 dark:hover:bg-gray-700 transition-colors">
            Last 30 Days
            <span class="material-symbols-outlined text-[18px]">expand_more</span>
        </button>
    </div>

    <div class="flex items-baseline gap-2 mb-6">
        <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Rp {{ number_format($revenueData->sum('total'), 0, ',', '.') }}</h2>
        <span class="px-2 py-0.5 rounded-full {{ $revenueTrend >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs font-semibold">
            {{ $revenueTrend >= 0 ? '+' : '' }}{{ round($revenueTrend, 1) }}%
        </span>
    </div>

    <div id="revenueChart" class="w-full h-[300px]"></div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var revenueData = @json($revenueData);
        
        var options = {
            series: [{
                name: 'Revenue',
                data: revenueData.map(item => item.total)
            }],
            chart: {
                type: 'area',
                height: 300,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                zoom: { enabled: false }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['#2563eb'] // blue-600
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 90, 100],
                    colorStops: [
                        {
                            offset: 0,
                            color: '#2563eb',
                            opacity: 0.4
                        },
                        {
                            offset: 100,
                            color: '#2563eb',
                            opacity: 0.0
                        }
                    ]
                }
            },
            xaxis: {
                categories: revenueData.map(item => {
                    let d = new Date(item.date);
                    return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
                }),
                labels: {
                    style: {
                        colors: '#94a3b8',
                        fontSize: '12px'
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#94a3b8',
                        fontSize: '12px'
                    },
                    formatter: function (value) {
                        if (value >= 1000000) {
                            return "Rp " + (value / 1000000).toFixed(1) + "M";
                        }
                        return "Rp " + (value / 1000).toFixed(0) + "k";
                    }
                }
            },
            grid: {
                strokeDashArray: 4,
                borderColor: '#e2e8f0',
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#revenueChart"), options);
        chart.render();
    });
</script>
@endpush
