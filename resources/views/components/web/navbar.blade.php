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
                <h1 class="font-serif text-3xl font-bold tracking-tight"
                    :class="{ 'text-white': {{ $isHome ? 'true' : 'false' }} && !isScrolled, 'text-textMain': !({{ $isHome ? 'true' : 'false' }}) || isScrolled }"
                >Maneé</h1>
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
                            <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm font-bold uppercase tracking-widest text-brandRed hover:bg-red-50 transition-colors">
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

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.away="mobileMenuOpen = false"
         class="lg:hidden absolute top-full left-0 w-full bg-white border-b border-gray-100 shadow-lg py-4 px-6 flex flex-col gap-4 text-textMain z-50">
            <a href="{{ route('home') }}" class="text-sm font-medium hover:text-blue-600">Home</a>
            <a href="{{ route('about') }}" class="text-sm font-medium hover:text-blue-600">About Maneé</a>
            <a href="{{ route('shop') }}" class="text-sm font-medium hover:text-blue-600">Shop</a>
            <a href="{{ route('shop', ['category' => 'knitwear']) }}" class="text-sm font-medium hover:text-blue-600">Knitwear</a>
            <a href="{{ route('shop', ['category' => 'tops']) }}" class="text-sm font-medium hover:text-blue-600">Tops</a>
            <a href="{{ route('shop', ['category' => 'bottoms']) }}" class="text-sm font-medium hover:text-blue-600">Bottoms</a>
            <hr class="border-gray-100">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" class="text-sm font-bold uppercase tracking-widest text-brandBlue italic">DASHBOARD: {{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-bold uppercase tracking-widest text-brandRed italic">LOGOUT</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-bold uppercase tracking-widest text-brandBlue italic">LOGIN / REGISTER</a>
            @endauth
    </div>
</header>
