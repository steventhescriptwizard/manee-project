<!-- Mobile Sidebar Overlay -->
<div 
    x-show="sidebarOpen" 
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden"
    @click="sidebarOpen = false"
></div>

<aside 
    :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
    class="fixed inset-y-0 left-0 z-50 w-64 border-r border-slate-200 dark:border-gray-800 flex flex-col flex-shrink-0 transition-transform duration-300 ease-in-out md:static md:translate-x-0 md:flex h-full"
    style="background-color: var(--sidebar-bg); color: var(--sidebar-text);"
>
    <!-- Brand -->
    <div class="p-6 border-b border-slate-100 dark:border-gray-800 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            @if(setting('site_logo'))
                <img src="{{ Storage::url(setting('site_logo')) }}" alt="{{ setting('site_name') }}" class="h-10 w-10 object-contain">
            @else
                <img src="{{ asset('images/Manee Logo_Main.svg') }}" alt="Maneé Logo" class="h-10 w-10 object-contain">
            @endif
            <div class="flex flex-col">
                <h1 class="text-slate-900 dark:text-white text-lg font-bold leading-none tracking-tight">{{ setting('site_name', 'Maneé Admin') }}</h1>
                <p class="text-slate-500 dark:text-slate-400 text-xs font-normal mt-1">Store Manager</p>
            </div>
        </div>
        
        <!-- Close Button (Mobile Only) -->
        <button 
            @click="sidebarOpen = false"
            class="md:hidden text-slate-500 hover:text-slate-900 dark:hover:text-white p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-gray-800"
        >
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- Nav Items -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        @php
            $navItems = [
                // Main
                ['icon' => 'dashboard', 'label' => __('sidebar.dashboard'), 'route' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard'), 'section' => __('sidebar.section_main')],
                
                // Sales (with divider before)
                [
                    'icon' => 'shopping_bag', 
                    'label' => __('sidebar.orders'), 
                    'route' => '#', 
                    'active' => request()->routeIs('admin.orders.*') || request()->routeIs('admin.outstanding.*'),
                    'section' => __('sidebar.section_sales'),
                    'submenu' => [
                        ['label' => __('sidebar.all_orders'), 'route' => route('admin.orders.index'), 'active' => request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show')],
                        ['label' => __('sidebar.outstanding'), 'route' => route('admin.outstanding.index'), 'active' => request()->routeIs('admin.outstanding.*')],
                    ]
                ],
                
                // Catalog (with divider before)
                ['icon' => 'checkroom', 'label' => __('sidebar.products'), 'route' => route('admin.products.index'), 'active' => request()->routeIs('admin.products.*'), 'section' => __('sidebar.section_catalog')],
                ['icon' => 'category', 'label' => __('sidebar.categories'), 'route' => route('admin.categories.index'), 'active' => request()->routeIs('admin.categories.*')],
                ['icon' => 'warehouse', 'label' => __('sidebar.warehouses'), 'route' => route('admin.warehouses.index'), 'active' => request()->routeIs('admin.warehouses.*')],
                
                // Marketing (with divider before)
                ['icon' => 'percent', 'label' => __('sidebar.discounts'), 'route' => route('admin.discounts.index'), 'active' => request()->routeIs('admin.discounts.*'), 'section' => __('sidebar.section_marketing')],
                ['icon' => 'campaign', 'label' => __('sidebar.marketing'), 'route' => route('admin.marketing.index'), 'active' => request()->routeIs('admin.marketing.*')],
                ['icon' => 'rate_review', 'label' => __('sidebar.reviews'), 'route' => route('admin.reviews.index'), 'active' => request()->routeIs('admin.reviews.*')],
                
                // System (with divider before)
                ['icon' => 'attach_money', 'label' => __('sidebar.taxes'), 'route' => route('admin.taxes.index'), 'active' => request()->routeIs('admin.taxes.*'), 'section' => __('sidebar.section_system')],
                ['icon' => 'group', 'label' => __('sidebar.customers'), 'route' => route('admin.customers.index'), 'active' => request()->routeIs('admin.customers.*')],
                ['icon' => 'admin_panel_settings', 'label' => __('sidebar.user_management'), 'route' => route('admin.users.index'), 'active' => request()->routeIs('admin.users.*')],
                ['icon' => 'inventory_2', 'label' => __('sidebar.inventory'), 'route' => route('admin.inventory.index'), 'active' => request()->routeIs('admin.inventory.*')],
                ['icon' => 'settings', 'label' => __('sidebar.settings'), 'route' => route('admin.settings.index'), 'active' => request()->routeIs('admin.settings.*')],
            ];
        @endphp

        @foreach($navItems as $item)
            {{-- Section Divider and Label --}}
            @if(isset($item['section']))
                <div class="border-t border-slate-200 dark:border-gray-800 my-3"></div>
                <p class="px-3 mb-2 text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">{{ $item['section'] }}</p>
            @endif

            @if(isset($item['submenu']))
                <div x-data="{ open: {{ $item['active'] ? 'true' : 'false' }} }" class="flex flex-col gap-1">
                    <button
                        @click="open = !open"
                        class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors group w-full text-left
                        {{ $item['active'] 
                            ? 'bg-blue-50/50 text-blue-600 font-semibold' 
                            : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-gray-800 hover:text-slate-900 dark:hover:text-white font-medium' 
                        }}"
                    >
                        <div class="flex items-center gap-3">
                            <span 
                                class="material-symbols-outlined text-[22px] {{ !$item['active'] ? 'group-hover:text-blue-600 transition-colors' : '' }}"
                                style="{{ $item['active'] ? "font-variation-settings: 'FILL' 1" : '' }}"
                            >
                                {{ $item['icon'] }}
                            </span>
                            <span class="text-sm">{{ $item['label'] }}</span>
                        </div>
                        <span class="material-symbols-outlined text-[20px] transition-transform duration-200" :class="{ 'rotate-180': open }">expand_more</span>
                    </button>
                    
                    <div x-show="open" x-collapse class="flex flex-col gap-1 pl-11 pr-3">
                        @foreach($item['submenu'] as $subItem)
                            <a 
                                href="{{ $subItem['route'] }}" 
                                class="flex items-center py-2 text-sm rounded-lg transition-colors
                                {{ $subItem['active']
                                    ? 'text-blue-600 font-semibold'
                                    : 'text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white'
                                }}"
                            >
                                {{ $subItem['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a
                    href="{{ $item['route'] }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group
                    {{ $item['active'] 
                        ? 'bg-blue-50 text-blue-600 font-semibold' 
                        : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-gray-800 hover:text-slate-900 dark:hover:text-white font-medium' 
                    }}"
                >
                    <span 
                        class="material-symbols-outlined text-[22px] {{ !$item['active'] ? 'group-hover:text-blue-600 transition-colors' : '' }}"
                        style="{{ $item['active'] ? "font-variation-settings: 'FILL' 1" : '' }}"
                    >
                        {{ $item['icon'] }}
                    </span>
                    <span class="text-sm">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endif
        @endforeach
    </nav>

    <!-- Logout Button -->
    <div class="p-4 border-t border-slate-200 dark:border-gray-800 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 font-medium transition-colors group">
                <span class="material-symbols-outlined text-[20px] group-hover:text-red-700">logout</span>
                <span class="text-sm">Logout</span>
            </button>
        </form>
    </div>
</aside>
