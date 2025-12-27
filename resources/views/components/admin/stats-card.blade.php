@props([
    'title',
    'value',
    'icon',
    'trend',
    'trendLabel',
    'iconColorClass',
    'iconBgClass',
    'trendPositive'
])

<div class="bg-white dark:bg-gray-900 p-5 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm flex flex-col gap-3">
    <div class="flex items-center justify-between">
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">{{ $title }}</p>
        <span class="material-symbols-outlined p-1.5 rounded-md text-[20px] {{ $iconColorClass }} {{ $iconBgClass }}">
            {{ $icon }}
        </span>
    </div>
    <div>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $value }}</h3>
        <div class="flex items-center gap-1 mt-1">
            <span class="material-symbols-outlined text-[16px] {{ $trendPositive ? 'text-green-600' : ($trend == 0 ? 'text-slate-400' : 'text-red-500') }}">
                {{ $trendPositive ? 'trending_up' : ($trend == 0 ? 'remove' : 'trending_down') }}
            </span>
            <p class="text-xs font-semibold {{ $trendPositive ? 'text-green-600' : ($trend == 0 ? 'text-slate-500' : 'text-red-500') }}">
                {{ $trend > 0 ? '+' : '' }}{{ $trend }}%
            </p>
            <p class="text-slate-400 text-xs ml-1">{{ $trendLabel }}</p>
        </div>
    </div>
</div>
