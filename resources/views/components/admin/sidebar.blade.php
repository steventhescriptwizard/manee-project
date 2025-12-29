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
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900 border-r border-slate-200 dark:border-gray-800 flex flex-col flex-shrink-0 transition-transform duration-300 ease-in-out md:static md:translate-x-0 md:flex h-full"
>
    <!-- Brand -->
    <div class="p-6 border-b border-slate-100 dark:border-gray-800 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/Manee Logo_Main.svg') }}" alt="Maneé Logo" class="h-10 w-10 object-contain">
            <div class="flex flex-col">
                <h1 class="text-slate-900 dark:text-white text-lg font-bold leading-none tracking-tight">Maneé Admin</h1>
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
                ['icon' => 'shopping_bag', 'label' => 'Orders', 'route' => route('admin.orders.index'), 'active' => request()->routeIs('admin.orders.*')],
                ['icon' => 'checkroom', 'label' => 'Products', 'route' => route('admin.products.index'), 'active' => request()->routeIs('admin.products.*')],
                ['icon' => 'category', 'label' => 'Categories', 'route' => route('admin.categories.index'), 'active' => request()->routeIs('admin.categories.*')],
                ['icon' => 'warehouse', 'label' => 'Warehouses', 'route' => route('admin.warehouses.index'), 'active' => request()->routeIs('admin.warehouses.*')],
                ['icon' => 'percent', 'label' => 'Discounts', 'route' => route('admin.discounts.index'), 'active' => request()->routeIs('admin.discounts.*')],
                ['icon' => 'attach_money', 'label' => 'Taxes', 'route' => route('admin.taxes.index'), 'active' => request()->routeIs('admin.taxes.*')],
                ['icon' => 'rate_review', 'label' => 'Reviews', 'route' => route('admin.reviews.index'), 'active' => request()->routeIs('admin.reviews.*')],
                ['icon' => 'group', 'label' => 'Pelanggan', 'route' => route('admin.customers.index'), 'active' => request()->routeIs('admin.customers.*')],
                ['icon' => 'admin_panel_settings', 'label' => 'Manajemen User', 'route' => route('admin.users.index'), 'active' => request()->routeIs('admin.users.*')],
                ['icon' => 'inventory_2', 'label' => 'Inventory', 'route' => route('admin.inventory.index'), 'active' => request()->routeIs('admin.inventory.*')],
                ['icon' => 'campaign', 'label' => 'Marketing', 'route' => '#', 'active' => false],
                ['icon' => 'settings', 'label' => 'Settings', 'route' => '#', 'active' => false],
            ];
            // Primary Color: Using text-blue-600/bg-blue-50 as generic primary interpretation or custom configured 'primary'
            // The React code uses 'text-primary' and 'bg-primary/10', implying a Tailwind configuration for 'primary'.
            // I will assume for now 'blue-600' is primary equivalent or use 'text-[color]' if I knew the hex.
            // Let's stick effectively to what the React code has but use a standard tailwind color if 'primary' isn't defined.
            // Actually, I'll use `text-blue-600` and `bg-blue-50` to approximate `primary`.
        @endphp

        @foreach($navItems as $item)
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
        @endforeach
    </nav>

    <!-- Logout Button -->
    <div class="p-4 border-t border-slate-200 dark:border-gray-800 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-red-600 hover:bg-red-50 font-medium transition-colors group">
                <span class="material-symbols-outlined text-[22px] group-hover:text-red-700">logout</span>
                <span class="text-sm">Logout</span>
            </button>
        </form>
    </div>
</aside>
