<aside class="w-64 bg-white dark:bg-gray-900 border-r border-slate-200 dark:border-gray-800 flex flex-col flex-shrink-0 z-20 transition-all duration-300 hidden md:flex h-full">
    <!-- Brand -->
    <div class="p-6 border-b border-slate-100 dark:border-gray-800 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div 
                class="bg-center bg-no-repeat bg-cover rounded-full h-10 w-10 shadow-sm"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBAQcBMqo23YoDYtJJDBxr9-_w9wgv-CrmlyJA9pRfFlwvSKvNE8ce424fWz2umL7byiYjmLvctF-xa1c1o-aXmu76WMZHdR5gr3FI2-gz1c2F-hJrHT_UXNLIV0LnqDnHg6F74xWFBxuqWkwr8qd-Qi781OlBdx2V1SGMq5AK7xMPZzbXWK6MvEHtzJNUwT-u-m9T-BPwmTiPqIHJ99hKKADiWDhnAtmTOg1dQUgOmya34wVeI1YguGM0sZTtfEUpS3p3A_xW9qHw')"
            ></div>
            <div class="flex flex-col">
                <h1 class="text-slate-900 dark:text-white text-lg font-bold leading-none tracking-tight">Maneé Admin</h1>
                <p class="text-slate-500 dark:text-slate-400 text-xs font-normal mt-1">Store Manager</p>
            </div>
        </div>
    </div>

    <!-- Nav Items -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        @php
            $navItems = [
                ['icon' => 'dashboard', 'label' => 'Dashboard', 'route' => '#', 'active' => true],
                ['icon' => 'shopping_bag', 'label' => 'Orders', 'route' => '#', 'active' => false],
                ['icon' => 'checkroom', 'label' => 'Products', 'route' => route('admin.products.index'), 'active' => request()->routeIs('admin.products.*')],
                ['icon' => 'category', 'label' => 'Categories', 'route' => route('admin.categories.index'), 'active' => request()->routeIs('admin.categories.*')],
                ['icon' => 'warehouse', 'label' => 'Warehouses', 'route' => route('admin.warehouses.index'), 'active' => request()->routeIs('admin.warehouses.*')],
                ['icon' => 'percent', 'label' => 'Discounts', 'route' => route('admin.discounts.index'), 'active' => request()->routeIs('admin.discounts.*')],
                ['icon' => 'group', 'label' => 'Customers', 'route' => '#', 'active' => false],
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

    <!-- Pro Plan Card -->
    <div class="p-4 border-t border-slate-200 dark:border-gray-800">
        <div class="bg-blue-50/50 rounded-lg p-4 flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-blue-600 uppercase">Pro Plan</span>
                <span class="material-symbols-outlined text-blue-600 text-sm">verified</span>
            </div>
            <div class="w-full bg-slate-200 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                <div class="bg-blue-600 w-3/4 h-full rounded-full"></div>
            </div>
            <p class="text-[10px] text-slate-500 dark:text-slate-400">850/1000 orders this month</p>
        </div>
    </div>
</aside>
