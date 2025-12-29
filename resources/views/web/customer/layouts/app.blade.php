@extends('layouts.web')

@section('content')
<div class="bg-white min-h-screen pt-24 pb-20">
    <div class="max-w-[1280px] mx-auto px-6 lg:px-10">
        
        <div class="mb-12 text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-bold font-serif text-[#111318] mb-3">
                @yield('header_title', 'Akun Saya')
            </h1>
            <p class="text-gray-500 font-sans text-lg italic font-light">
                @yield('header_subtitle', 'Kelola profil dan preferensi belanja Anda.')
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
            <!-- Sidebar -->
            <aside class="w-full lg:w-72 flex-shrink-0">
                <nav class="flex flex-col gap-2">
                    @php
                        $navItems = [
                            ['id' => 'customer.dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],
                            ['id' => 'profile.edit', 'label' => 'Profil Saya', 'icon' => 'person'],
                            ['id' => 'customer.orders', 'label' => 'Riwayat Pesanan', 'icon' => 'shopping_bag'],
                            ['id' => 'customer.address', 'label' => 'Alamat Saya', 'icon' => 'location_on'],
                            ['id' => 'customer.payment', 'label' => 'Metode Pembayaran', 'icon' => 'credit_card'],
                            ['id' => 'wishlist', 'label' => 'Wishlist', 'icon' => 'favorite'],
                        ];
                    @endphp

                    @foreach($navItems as $item)
                        @php 
                            $isActive = request()->routeIs($item['id'] . '*'); 
                        @endphp
                        <a href="{{ Route::has($item['id']) ? route($item['id']) : '#' }}" 
                           class="flex items-center gap-4 px-5 py-4 rounded-2xl font-bold transition-all border-l-4 {{ $isActive ? 'bg-brandBlue/5 text-brandBlue border-brandBlue shadow-sm' : 'text-gray-500 hover:bg-gray-50 border-transparent hover:text-brandBlue' }} group">
                            <span class="material-symbols-outlined text-[24px] {{ !$isActive ? 'group-hover:scale-110 transition-transform' : '' }}">
                                {{ $item['icon'] }}
                            </span>
                            <span class="text-sm uppercase tracking-widest">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                    
                    <div class="h-px bg-gray-100 my-4 mx-4"></div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-4 px-5 py-4 rounded-2xl font-bold text-red-500 hover:bg-red-50 transition-all w-full text-left uppercase tracking-widest text-sm border-l-4 border-transparent hover:border-red-200">
                            <span class="material-symbols-outlined text-[24px]">logout</span>
                            Keluar
                        </button>
                    </form>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 min-w-0">
                @yield('customer_content')
            </div>
        </div>
    </div>
</div>

<style>
    .fill-1 { font-variation-settings: 'FILL' 1; }
</style>
@endsection
