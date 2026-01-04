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
                ['icon' => 'dashboard', 'label' => 'Dashboard', 'route' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard')],
                [
                    'icon' => 'shopping_bag', 
                    'label' => 'Orders', 
                    'route' => '#', 
                    'active' => request()->routeIs('admin.orders.*') || request()->routeIs('admin.outstanding.*'),
                    'submenu' => [
                        ['label' => 'Orders', 'route' => route('admin.orders.index'), 'active' => request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show')],
                        ['label' => 'Outstanding Sales', 'route' => route('admin.outstanding.index'), 'active' => request()->routeIs('admin.outstanding.*')],
                    ]
                ],
                ['icon' => 'checkroom', 'label' => 'Products', 'route' => route('admin.products.index'), 'active' => request()->routeIs('admin.products.*')],
                ['icon' => 'category', 'label' => 'Categories', 'route' => route('admin.categories.index'), 'active' => request()->routeIs('admin.categories.*')],
                ['icon' => 'warehouse', 'label' => 'Warehouses', 'route' => route('admin.warehouses.index'), 'active' => request()->routeIs('admin.warehouses.*')],
                ['icon' => 'percent', 'label' => 'Discounts', 'route' => route('admin.discounts.index'), 'active' => request()->routeIs('admin.discounts.*')],
                ['icon' => 'attach_money', 'label' => 'Taxes', 'route' => route('admin.taxes.index'), 'active' => request()->routeIs('admin.taxes.*')],
                ['icon' => 'rate_review', 'label' => 'Reviews', 'route' => route('admin.reviews.index'), 'active' => request()->routeIs('admin.reviews.*')],
                ['icon' => 'group', 'label' => 'Pelanggan', 'route' => route('admin.customers.index'), 'active' => request()->routeIs('admin.customers.*')],
                ['icon' => 'admin_panel_settings', 'label' => 'Manajemen User', 'route' => route('admin.users.index'), 'active' => request()->routeIs('admin.users.*')],
                ['icon' => 'inventory_2', 'label' => 'Inventory', 'route' => route('admin.inventory.index'), 'active' => request()->routeIs('admin.inventory.*')],
                ['icon' => 'campaign', 'label' => 'Marketing', 'route' => route('admin.marketing.index'), 'active' => request()->routeIs('admin.marketing.*')],
                ['icon' => 'settings', 'label' => 'Settings', 'route' => route('admin.settings.index'), 'active' => request()->routeIs('admin.settings.*')],
            ];
        @endphp

        @foreach($navItems as $item)
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

    <!-- Theme Toggles (Slicing Implementation) -->
    <div class="p-4 border-t border-slate-200 dark:border-gray-800 mt-auto">
        <div class="mb-4 px-2" x-data="{ 
            setTheme(bg, text, primary) {
                 // Update CSS variables immediately for preview
                 document.documentElement.style.setProperty('--sidebar-bg', bg);
                 document.documentElement.style.setProperty('--sidebar-text', text);
                 document.documentElement.style.setProperty('--primary-color', primary);

                 // Send to backend to save
                 fetch('{{ route('admin.settings.update-appearance') }}', {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     },
                     body: JSON.stringify({
                         appearance_sidebar_bg: bg,
                         appearance_sidebar_text: text,
                         appearance_primary_color: primary
                     })
                 });
            }
        }">
            <p class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 mb-2 tracking-wider">Sidebar Theme</p>
            <div class="flex items-center gap-2">
                <!-- Light -->
                <button @click="setTheme('#ffffff', '#334155', '#3b82f6')" 
                    class="w-6 h-6 rounded-full bg-white border-2 border-blue-500 shadow-sm hover:scale-110 transition-transform" title="Light"></button>
                <!-- Dark -->
                <button @click="setTheme('#0f172a', '#e2e8f0', '#0ea5e9')" 
                    class="w-6 h-6 rounded-full bg-slate-900 border border-slate-700 hover:scale-110 transition-transform" title="Dark"></button>
                <!-- Navy -->
                <button @click="setTheme('#1e293b', '#e2e8f0', '#3b82f6')" 
                    class="w-6 h-6 rounded-full bg-slate-800 border border-slate-600 hover:scale-110 transition-transform" title="Navy"></button>
                <!-- Zinc -->
                <button @click="setTheme('#3f3f46', '#e4e4e7', '#a1a1aa')" 
                    class="w-6 h-6 rounded-full bg-zinc-700 border border-zinc-600 hover:scale-110 transition-transform" title="Zinc"></button>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 font-medium transition-colors group">
                <span class="material-symbols-outlined text-[20px] group-hover:text-red-700">logout</span>
                <span class="text-sm">Logout</span>
            </button>
        </form>
    </div>
</aside>
