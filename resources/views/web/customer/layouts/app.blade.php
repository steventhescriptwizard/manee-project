@extends('layouts.web')

@section('content')
<div class="bg-white min-h-screen pt-24 pb-20">
    <div class="max-w-[1280px] mx-auto px-6 lg:px-10">
        


        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
            <!-- Sidebar -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl border border-gray-100 p-6 sticky top-24">
                    <!-- User Profile -->
                    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-gray-100">
                        <div class="w-12 h-12 bg-brandBlue/10 rounded-full flex items-center justify-center text-brandBlue font-display font-bold text-xl">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Akun Saya</p>
                            <p class="font-display font-semibold text-lg leading-tight truncate text-[#111318]">{{ Auth::user()->name }}</p>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex flex-col gap-1">
                        @php
                            $navItems = [
                                ['id' => 'customer.dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],
                                ['id' => 'profile.edit', 'label' => 'Profil Saya', 'icon' => 'person'],
                                ['id' => 'customer.orders', 'label' => 'Riwayat Pesanan', 'icon' => 'shopping_bag'],
                                ['id' => 'customer.notifications.index', 'label' => 'Notifikasi', 'icon' => 'notifications'],
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
                               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all relative {{ $isActive ? 'bg-brandBlue/10 text-[#111318] font-medium border-l-4 border-brandBlue' : 'text-gray-500 hover:bg-gray-50 hover:text-[#111318] border-l-4 border-transparent' }}">
                                <span class="material-symbols-outlined text-[20px] {{ $isActive ? 'fill-1' : '' }}">
                                    {{ $item['icon'] }}
                                </span>
                                <span class="text-sm flex-1">{{ $item['label'] }}</span>
                                @if($item['id'] === 'customer.notifications.index' && Auth::user()->unreadNotifications->count() > 0)
                                    <span class="flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-red-500 text-white text-[10px] font-bold animate-pulse">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                        
                        <div class="pt-4 mt-2 border-t border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-500 hover:bg-red-50 transition-all w-full text-left text-sm">
                                    <span class="material-symbols-outlined text-[20px]">logout</span>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
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
