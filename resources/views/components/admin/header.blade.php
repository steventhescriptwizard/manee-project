<header class="h-16 bg-white dark:bg-gray-900 border-b border-slate-200 dark:border-gray-800 flex items-center justify-between px-6 z-10 flex-shrink-0">
    <div class="flex items-center gap-4">
        <!-- Mobile Menu Button -->
        <button 
            @click="sidebarOpen = true"
            class="md:hidden text-slate-500 hover:text-slate-900 dark:hover:text-white"
        >
            <span class="material-symbols-outlined">menu</span>
        </button>
        <h2 class="text-slate-900 dark:text-white text-lg font-bold leading-tight hidden sm:block">
            Overview
        </h2>
    </div>
    
    <div class="flex items-center gap-6">
        <!-- Search -->
        <div 
            class="hidden md:flex relative w-64 lg:w-80 h-10"
            x-data="{ 
                searchQuery: '', 
                searchResults: { products: [], customers: [], orders: [] },
                isSearching: false,
                showResults: false,
                async performSearch() {
                    if (this.searchQuery.length < 2) {
                        this.searchResults = { products: [], customers: [], orders: [] };
                        this.showResults = false;
                        return;
                    }
                    this.isSearching = true;
                    try {
                        const response = await fetch(`{{ route('admin.search') }}?q=${encodeURIComponent(this.searchQuery)}`);
                        this.searchResults = await response.json();
                        this.showResults = true;
                    } catch (error) {
                        console.error('Search error:', error);
                    } finally {
                        this.isSearching = false;
                    }
                }
            }"
        >
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                <span class="material-symbols-outlined text-[20px]" x-show="!isSearching">search</span>
                <span class="material-symbols-outlined text-[20px] animate-spin" x-show="isSearching" x-cloak>sync</span>
            </div>
            <input 
                type="text" 
                x-model="searchQuery"
                @input.debounce.300ms="performSearch()"
                @focus="if(searchQuery.length >= 2) showResults = true"
                @click.away="showResults = false"
                class="bg-slate-100 dark:bg-gray-800 border-none text-slate-900 dark:text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-600 focus:bg-white dark:focus:bg-gray-800 block w-full pl-10 p-2.5 placeholder-slate-400 transition-all outline-none" 
                placeholder="Search orders, products..." 
            />

            <!-- Search Results Dropdown -->
            <div 
                x-show="showResults"
                x-cloak
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="absolute left-0 top-full mt-2 w-full lg:w-[450px] bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-gray-700 z-[60] overflow-hidden flex flex-col"
                x-data="{ activeFilter: 'all' }"
            >
                <!-- Search Quick Filters -->
                <div class="px-4 py-3 bg-slate-50 dark:bg-gray-800/80 border-b border-slate-100 dark:border-gray-700 flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <button 
                        @click="activeFilter = 'all'"
                        :class="activeFilter === 'all' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-700 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-gray-600'"
                        class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all flex-shrink-0"
                    >Semua</button>
                    <button 
                        @click="activeFilter = 'products'"
                        :class="activeFilter === 'products' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-700 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-gray-600'"
                        class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all flex-shrink-0"
                    >Produk</button>
                    <button 
                        @click="activeFilter = 'customers'"
                        :class="activeFilter === 'customers' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-700 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-gray-600'"
                        class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all flex-shrink-0"
                    >Pelanggan</button>
                    <button 
                        @click="activeFilter = 'orders'"
                        :class="activeFilter === 'orders' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-700 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-gray-600'"
                        class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all flex-shrink-0"
                    >Order</button>
                </div>

                <div class="max-h-[80vh] overflow-y-auto">
                    {{-- Products --}}
                    <template x-if="(activeFilter === 'all' || activeFilter === 'products') && searchResults.products.length > 0">
                        <div>
                            <div class="px-4 py-2 bg-slate-50/50 dark:bg-gray-750/30 border-b border-slate-100 dark:border-gray-700">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Products</span>
                            </div>
                            <template x-for="item in searchResults.products" :key="item.url">
                                <a :href="item.url" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-gray-750 transition-colors border-b border-slate-50 dark:border-gray-750/50">
                                    <div class="size-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-[18px]" x-text="item.icon"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-900 dark:text-white truncate" x-text="item.label"></p>
                                        <p class="text-[10px] text-slate-500 font-medium" x-text="item.sub"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </template>

                    {{-- Customers --}}
                    <template x-if="(activeFilter === 'all' || activeFilter === 'customers') && searchResults.customers.length > 0">
                        <div>
                            <div class="px-4 py-2 bg-slate-50/50 dark:bg-gray-750/30 border-b border-slate-100 dark:border-gray-700">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Customers</span>
                            </div>
                            <template x-for="item in searchResults.customers" :key="item.url">
                                <a :href="item.url" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-gray-750 transition-colors border-b border-slate-50 dark:border-gray-750/50">
                                    <div class="size-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-[18px]" x-text="item.icon"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-900 dark:text-white truncate" x-text="item.label"></p>
                                        <p class="text-[10px] text-slate-500 font-medium" x-text="item.sub"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </template>

                    {{-- Orders --}}
                    <template x-if="(activeFilter === 'all' || activeFilter === 'orders') && searchResults.orders.length > 0">
                        <div>
                            <div class="px-4 py-2 bg-slate-50/50 dark:bg-gray-750/30 border-b border-slate-100 dark:border-gray-700">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Nomor Pesanan</span>
                            </div>
                            <template x-for="item in searchResults.orders" :key="item.url">
                                <a :href="item.url" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-gray-750 transition-colors border-b border-slate-50 dark:border-gray-750/50">
                                    <div class="size-8 rounded-lg bg-amber-50 dark:bg-amber-900/20 text-amber-600 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-[18px]" x-text="item.icon"></span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-900 dark:text-white truncate" x-text="item.label"></p>
                                        <p class="text-[10px] text-slate-500 font-medium" x-text="item.sub"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </template>

                    {{-- No Results --}}
                    <template x-if="searchResults.products.length === 0 && searchResults.customers.length === 0 && searchResults.orders.length === 0">
                        <div class="p-8 text-center">
                            <span class="material-symbols-outlined text-slate-200 dark:text-gray-700 text-4xl mb-2">search_off</span>
                            <p class="text-xs text-slate-400 font-medium italic">Tidak ada hasil ditemukan untuk "<span class="font-bold" x-text="searchQuery"></span>"</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Notifications -->
            <div class="relative" x-data="{ notificationsOpen: false }">
                <button 
                    @click="notificationsOpen = !notificationsOpen"
                    @click.away="notificationsOpen = false"
                    class="relative p-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-white transition-colors rounded-full hover:bg-slate-100 dark:hover:bg-gray-800"
                >
                    <span class="material-symbols-outlined text-[24px]">notifications</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute top-2 right-2 h-4 w-4 bg-red-500 rounded-full border-2 border-white dark:border-gray-900 text-[8px] font-black text-white flex items-center justify-center">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>

                <!-- Notifications Dropdown -->
                <div 
                    x-show="notificationsOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-80 rounded-2xl bg-white dark:bg-gray-800 shadow-xl border border-slate-100 dark:border-gray-700 z-50 overflow-hidden"
                >
                    <div class="p-4 border-b border-slate-50 dark:border-gray-700 flex items-center justify-between bg-slate-50/50 dark:bg-gray-800/50">
                        <h3 class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-widest">Notifikasi</h3>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <a href="#" class="text-[10px] font-bold text-blue-600 hover:underline">Tandai semua dibaca</a>
                        @endif
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @forelse(auth()->user()->notifications->take(5) as $notification)
                            <div class="p-4 border-b border-slate-50 dark:border-gray-700/50 hover:bg-slate-50 dark:hover:bg-gray-750 transition-colors {{ $notification->unread() ? 'bg-blue-50/30 dark:bg-blue-900/10' : '' }}">
                                <div class="flex gap-3">
                                    <div class="size-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">shopping_cart_checkout</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs font-bold text-slate-900 dark:text-white">{{ $notification->data['message'] }}</p>
                                        <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Order #{{ $notification->data['order_number'] }} • {{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <span class="material-symbols-outlined text-slate-200 dark:text-gray-700 text-4xl mb-2">notifications_off</span>
                                <p class="text-xs text-slate-400 font-medium">Tidak ada notifikasi baru</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <div class="h-8 w-px bg-slate-200 dark:bg-gray-800 mx-1"></div>
            
            <!-- User Profile -->
            <div class="relative">
                <button 
                    @click="userDropdownOpen = !userDropdownOpen"
                    @click.away="userDropdownOpen = false"
                    class="flex items-center gap-3 hover:bg-slate-50 dark:hover:bg-gray-800 p-1.5 rounded-full pr-3 transition-colors"
                >
                    <div class="relative size-8 rounded-full border border-slate-200 dark:border-gray-700 overflow-hidden bg-slate-100 dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-slate-400 text-[18px]">person</span>
                        @endif
                    </div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-200 hidden sm:block">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <span 
                        class="material-symbols-outlined text-slate-400 text-[20px] hidden sm:block transition-transform duration-200"
                        :class="{ 'rotate-180': userDropdownOpen }"
                    >expand_more</span>
                </button>

                <!-- Dropdown Menu -->
                <div 
                    x-show="userDropdownOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 rounded-2xl bg-white dark:bg-gray-800 shadow-xl border border-slate-100 dark:border-gray-700 py-1 z-50 overflow-hidden"
                >
                    <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-gray-700/50 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                        Profil Saya
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-gray-700/50 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">settings</span>
                        Pengaturan
                    </a>
                    <div class="h-px bg-slate-100 dark:bg-gray-700 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">logout</span>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
