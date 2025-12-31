@php
    $isHome = request()->routeIs('home');
@endphp

<header 
    x-data="{ 
        isScrolled: false, 
        mobileMenuOpen: false,
        userDropdownOpen: false,
        init() {
            window.addEventListener('scroll', () => {
                this.isScrolled = window.scrollY > 50;
            });
            this.$watch('mobileMenuOpen', value => {
                if (value) {
                    document.body.classList.add('overflow-hidden');
                } else {
                    document.body.classList.remove('overflow-hidden');
                }
            });
        }
    }"
    :class="{
        'bg-transparent text-white border-transparent': {{ $isHome ? 'true' : 'false' }} && !isScrolled,
        'bg-white/95 backdrop-blur-md text-textMain border-b border-gray-100 shadow-sm': !{{ $isHome ? 'true' : 'false' }} || isScrolled
    }"
    class="fixed top-0 w-full z-50 transition-all duration-300"
>
    <!-- Dark overlay for home hero when not scrolled -->
    <div 
        class="absolute inset-0 bg-gradient-to-b from-black/50 to-transparent pointer-events-none transition-opacity duration-300"
        :class="{ 'opacity-100': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'opacity-0': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
    ></div>

    <div class="container mx-auto px-6 py-4 flex justify-between items-center relative z-10 h-16 md:h-20">
        <div class="flex items-center gap-4">
            <!-- Mobile Menu Button -->
            <button class="lg:hidden" @click="mobileMenuOpen = !mobileMenuOpen">
                <span class="material-symbols-outlined text-[24px] cursor-pointer"
                    :class="{ 'text-white': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >menu</span>
            </button>
            
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <!-- White Logo (Secondary) -->
                <img 
                    src="{{ asset('images/Manee Logo_Secondary (1).svg') }}" 
                    alt="Maneé Logo" 
                    class="h-6 md:h-8 object-contain"
                    x-show="{{ $isHome ? 'true' : 'false' }} && !isScrolled"
                />
                
                <!-- Black Logo (Main) -->
                <img 
                    src="{{ asset('images/Manee Logo_Main.svg') }}" 
                    alt="Maneé Logo" 
                    class="h-6 md:h-8 object-contain"
                    x-show="!({{ $isHome ? 'true' : 'false' }}) || isScrolled"
                    style="display: none;" 
                />
            </a>
            
            <!-- Desktop Nav -->
            <nav class="hidden lg:flex items-center gap-8 ml-8">
                <a href="{{ route('home') }}" class="text-sm font-medium transition-colors hover:text-blue-600"
                   :class="{ 'text-white hover:text-gray-200': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >Home</a>
                <a href="{{ route('about') }}" class="text-sm font-medium transition-colors hover:text-blue-600"
                   :class="{ 'text-white hover:text-gray-200': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >About Maneé</a>
                <a href="{{ route('shop') }}" class="text-sm font-medium transition-colors hover:text-blue-600"
                   :class="{ 'text-white hover:text-gray-200': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >Shop</a>
                <a href="{{ route('shop', ['category' => 'knitwear']) }}" class="text-sm font-medium transition-colors hover:text-blue-600"
                   :class="{ 'text-white hover:text-gray-200': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >Knitwear</a>
                <a href="{{ route('shop', ['category' => 'tops']) }}" class="text-sm font-medium transition-colors hover:text-blue-600"
                   :class="{ 'text-white hover:text-gray-200': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >Tops</a>
                <a href="{{ route('shop', ['category' => 'bottoms']) }}" class="text-sm font-medium transition-colors hover:text-blue-600"
                   :class="{ 'text-white hover:text-gray-200': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >Bottoms</a>
            </nav>
        </div>

        <div class="flex items-center gap-4 md:gap-6">
            <!-- Search Bar -->
            <form action="{{ route('shop') }}" method="GET" class="hidden md:flex items-center rounded-full px-4 py-1.5 transition-all"
                  :class="{ 'bg-white/20 border border-white/30': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'bg-gray-100': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
            >
                <span class="material-symbols-outlined text-[20px]"
                      :class="{ 'text-white/80': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-gray-500': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >search</span>
                <input 
                    type="text" 
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Find products..." 
                    class="bg-transparent border-none outline-none text-sm w-32 ml-2 focus:ring-0 p-0 placeholder-current"
                    :class="{ 'text-white placeholder-white/70': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain placeholder-gray-400': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                />
            </form>

            <button class="hidden md:block">
                <span class="material-symbols-outlined text-[24px] cursor-pointer"
                      :class="{ 'text-white': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >search</span>
            </button>
            
            @auth
                <div class="relative hidden md:block">
                    <button 
                        @click="userDropdownOpen = !userDropdownOpen"
                        @click.away="userDropdownOpen = false"
                        class="hover:opacity-80 group flex items-center gap-2"
                    >
                        <span class="text-[11px] font-bold uppercase tracking-[0.2em] transition-colors"
                              :class="{ 'text-white hover:text-gray-200': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                        >{{ auth()->user()->name }}</span>
                        <span class="material-symbols-outlined text-[24px] cursor-pointer"
                              :class="{ 'text-white': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                        >account_circle</span>
                    </button>

                    <!-- User Dropdown Menu -->
                    <div 
                        x-show="userDropdownOpen"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 rounded-2xl bg-white shadow-xl border border-gray-100 py-2 z-50 text-textMain"
                    >
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-bold uppercase tracking-widest hover:bg-gray-50 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">dashboard</span>
                            Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-bold uppercase tracking-widest hover:bg-gray-50 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">person</span>
                            Profile
                        </a>
                        <div class="h-px bg-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn flex w-full items-center gap-2 px-4 py-2 text-sm font-bold uppercase tracking-widest text-brandRed hover:bg-red-50 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="hidden md:block hover:opacity-80">
                    <span class="text-[11px] font-bold uppercase tracking-[0.2em] transition-colors"
                          :class="{ 'text-white hover:text-gray-200': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                    >Login</span>
                </a>
            @endauth

            <a href="{{ route('wishlist') }}" 
               x-data="{ count: {{ count(session()->get('wishlist', [])) }} }"
               @wishlist-updated.window="count = $event.detail.count"
               class="relative flex items-center justify-center hover:opacity-80">
                <span class="material-symbols-outlined text-[24px] cursor-pointer"
                      :class="{ 'text-white': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >bookmark</span>
                <span x-show="count > 0"
                      x-text="count"
                      class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full text-[10px] font-bold"
                      :class="{ 'bg-white text-black': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'bg-brandRed text-white': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                ></span>
            </a>

            <a href="{{ route('cart') }}" 
               x-data="{ count: {{ count(session()->get('cart', [])) }} }"
               @cart-updated.window="count = $event.detail.count"
               class="relative flex items-center justify-center hover:opacity-80">
                <span class="material-symbols-outlined text-[24px] cursor-pointer"
                      :class="{ 'text-white': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >shopping_bag</span>
                <span x-show="count > 0"
                      x-text="count"
                      class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full text-[10px] font-bold"
                      :class="{ 'bg-white text-black': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'bg-blue-600 text-white': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                ></span>
            </a>
        </div>
    </div>

    <!-- Mobile Menu Drawer -->
    <div 
        x-show="mobileMenuOpen" 
        class="lg:hidden fixed inset-0 z-[60]"
        x-cloak
    >
        <!-- Backdrop -->
        <div 
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="mobileMenuOpen = false"
            class="absolute inset-0 bg-black/40 backdrop-blur-sm"
        ></div>

        <!-- Drawer Content -->
        <div 
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="absolute top-0 left-0 w-[85%] max-w-[320px] h-[100dvh] bg-white shadow-2xl flex flex-col"
        >
            <!-- Drawer Header -->
            <div class="p-6 flex justify-between items-center border-b border-gray-50">
                <img src="{{ asset('images/Manee Logo_Main.svg') }}" alt="Maneé Logo" class="h-6 object-contain" />
                <button @click="mobileMenuOpen = false" class="text-textMain hover:rotate-90 transition-transform duration-300">
                    <span class="material-symbols-outlined text-[28px]">close</span>
                </button>
            </div>

            <!-- Drawer Links -->
            <nav class="flex-1 overflow-y-auto py-8 px-6 flex flex-col gap-6">
                <a href="{{ route('home') }}" class="text-2xl font-serif italic text-textMain hover:text-blue-600 transition-colors">Home</a>
                <a href="{{ route('about') }}" class="text-2xl font-serif italic text-textMain hover:text-blue-600 transition-colors">About Maneé</a>
                
                <div class="h-px bg-gray-100 my-2"></div>
                
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-2">Categories</p>
                <a href="{{ route('shop') }}" class="text-xl font-sans font-light text-textMain hover:translate-x-2 transition-transform capitalize">All Collections</a>
                <a href="{{ route('shop', ['category' => 'knitwear']) }}" class="text-xl font-sans font-light text-textMain hover:translate-x-2 transition-transform capitalize">Knitwear</a>
                <a href="{{ route('shop', ['category' => 'tops']) }}" class="text-xl font-sans font-light text-textMain hover:translate-x-2 transition-transform capitalize">Tops</a>
                <a href="{{ route('shop', ['category' => 'bottoms']) }}" class="text-xl font-sans font-light text-textMain hover:translate-x-2 transition-transform capitalize">Bottoms</a>
            </nav>

            <!-- Drawer Footer -->
            <div class="p-8 bg-gray-50 border-t border-gray-100">
                @auth
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="material-symbols-outlined text-gray-400">account_circle</span>
                            <span class="text-sm font-medium text-textMain">{{ auth()->user()->name }}</span>
                        </div>
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" class="text-xs font-bold uppercase tracking-[0.2em] text-blue-600 hover:opacity-80 transition-opacity">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn text-xs font-bold uppercase tracking-[0.2em] text-brandRed hover:opacity-80 transition-opacity">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center py-4 bg-textMain text-white text-xs font-bold uppercase tracking-[0.2em] hover:bg-black transition-colors rounded-lg">
                        Login / Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
