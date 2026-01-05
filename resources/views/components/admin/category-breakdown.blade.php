<div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Sales by Category</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Top performing categories</p>
        </div>
    </div>

    <div id="categoryChart" class="w-full h-[300px]"></div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var categoryData = @json($categoryBreakdown);
        
        var options = {
            series: categoryData.map(item => parseFloat(item.total)),
            chart: {
                type: 'donut',
                height: 300,
                fontFamily: 'Inter, sans-serif'
            },
            labels: categoryData.map(item => item.name),
            colors: ['#2563eb', '#7c3aed', '#db2777', '#ea580c', '#65a30d'],
            legend: {
                position: 'bottom',
                labels: {
                    colors: '#94a3b8'
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val.toFixed(1) + "%"
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '14px',
                                color: '#94a3b8',
                                formatter: function (w) {
                                    const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                                }
                            }
                        }
                    }
                }
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

        var chart = new ApexCharts(document.querySelector("#categoryChart"), options);
        chart.render();
    });
</script>
@endpush
