@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
<nav class="flex items-center gap-2 text-xs font-medium mb-6 overflow-x-auto no-scrollbar py-1">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5 text-slate-500 hover:text-blue-600 transition-colors shrink-0">
        <span class="material-symbols-outlined text-[18px]">home</span>
        Dashboard
    </a>
    
    @foreach($breadcrumbs as $breadcrumb)
        <span class="text-slate-300 dark:text-gray-700 shrink-0">
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        </span>
        
        @if($loop->last)
            <span class="text-slate-900 dark:text-white font-bold truncate">
                {{ $breadcrumb['label'] }}
            </span>
        @else
            <a href="{{ $breadcrumb['url'] }}" class="text-slate-500 hover:text-blue-600 transition-colors truncate shrink-0">
                {{ $breadcrumb['label'] }}
            </a>
        @endif
    @endforeach
</nav>
@endif
