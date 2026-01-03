@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
            
            {{-- Mobile Pagination --}}
            <div class="flex gap-2 items-center justify-between w-full sm:hidden">
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 cursor-not-allowed rounded-lg dark:text-gray-500 dark:bg-gray-800 dark:border-gray-700">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                        {!! __('pagination.previous') !!}
                    </a>
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white">
                        {!! __('pagination.next') !!}
                    </a>
                @else
                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 cursor-not-allowed rounded-lg dark:text-gray-500 dark:bg-gray-800 dark:border-gray-700">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </div>

            {{-- Desktop Pagination --}}
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        {!! __('Showing') !!}
                        @if ($paginator->firstItem())
                            <span class="font-semibold text-slate-900 dark:text-white">{{ $paginator->firstItem() }}</span>
                            {!! __('to') !!}
                            <span class="font-semibold text-slate-900 dark:text-white">{{ $paginator->lastItem() }}</span>
                        @else
                            {{ $paginator->count() }}
                        @endif
                        {!! __('of') !!}
                        <span class="font-semibold text-slate-900 dark:text-white">{{ $paginator->total() }}</span>
                        {!! __('results') !!}
                    </p>
                </div>

                <div>
                    <span class="inline-flex gap-1 shadow-sm rounded-md isolate">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <span class="inline-flex items-center px-2.5 py-2 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 cursor-not-allowed rounded-l-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-500">
                                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                </span>
                            </span>
                        @else
                            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-2.5 py-2 text-sm font-medium text-slate-500 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50 hover:text-slate-700 transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-slate-400 dark:hover:bg-gray-700 dark:hover:text-white" aria-label="{{ __('pagination.previous') }}">
                                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-500 bg-slate-50 border border-slate-200 cursor-default dark:bg-gray-800 dark:border-gray-700 dark:text-slate-400">{{ $element }}</span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page">
                                            <span class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 border border-blue-600 cursor-default dark:bg-blue-600 dark:border-blue-600">{{ $page }}</span>
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-900 transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-slate-300 dark:hover:bg-gray-700 dark:hover:text-white" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-2.5 py-2 text-sm font-medium text-slate-500 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50 hover:text-slate-700 transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-slate-400 dark:hover:bg-gray-700 dark:hover:text-white" aria-label="{{ __('pagination.next') }}">
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </a>
                        @else
                            <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                <span class="inline-flex items-center px-2.5 py-2 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 cursor-not-allowed rounded-r-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-500">
                                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                </span>
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </nav>
@endif
