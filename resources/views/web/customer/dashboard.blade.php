@extends('web.customer.layouts.app')

@section('customer_content')
<div class="space-y-10 animate-fade-in">
    
    <!-- Welcome Banner -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-display font-bold text-[#111318] mb-2">Halo, {{ $user->name }}!</h1>
            <p class="text-gray-500 font-light">Selamat datang kembali di dashboard akun Anda.</p>
        </div>
        <a href="{{ route('shop') }}" class="hidden md:inline-flex items-center justify-center h-10 px-6 font-medium text-white bg-brandBlue hover:bg-brandBlue/90 rounded-full transition-colors shadow-sm">
            Mulai Belanja
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
        <!-- Last Order -->
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex flex-col justify-between h-full relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-[64px] text-gray-400">local_shipping</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1 font-medium">Pesanan Terakhir</p>
                @if($lastOrder = $recentOrders->first())
                    <h3 class="text-2xl font-display font-bold text-[#111318] mb-2">#{{ $lastOrder->order_number }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide
                        {{ $lastOrder->status === 'Dikirim' ? 'bg-blue-100 text-blue-800' : 
                           ($lastOrder->status === 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $lastOrder->status }}
                    </span>
                    <div class="mt-6 pt-4 border-t border-dashed border-gray-200 relative z-10">
                        <a href="{{ route('customer.orders.show', $lastOrder->id) }}" class="text-sm font-medium text-[#111318] hover:text-brandBlue flex items-center gap-1 group/link">
                            Lacak Pesanan 
                            <span class="material-symbols-outlined text-[16px] transition-transform group-hover/link:translate-x-1">arrow_forward</span>
                        </a>
                    </div>
                @else
                    <h3 class="text-xl font-display font-bold text-[#111318] mb-2">Belum ada</h3>
                    <div class="mt-6 pt-4 border-t border-dashed border-gray-200 relative z-10">
                        <a href="{{ route('shop') }}" class="text-sm font-medium text-[#111318] hover:text-brandBlue flex items-center gap-1 group/link">
                            Belanja Sekarang
                            <span class="material-symbols-outlined text-[16px] transition-transform group-hover/link:translate-x-1">arrow_forward</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex flex-col justify-between h-full relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-[64px] text-gray-400">notifications</span>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1 font-medium">Notifikasi</p>
                @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
                <h3 class="text-2xl font-display font-bold text-[#111318] mb-2">
                    {{ $unreadCount }} Pesan Baru
                </h3>
                <p class="text-xs text-gray-500">
                    {{ $unreadCount > 0 ? 'Cek update status pesanan dan promo.' : 'Tidak ada notifikasi baru saat ini.' }}
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-dashed border-gray-200 relative z-10">
                <a href="{{ route('customer.notifications.index') }}" class="text-sm font-medium text-[#111318] hover:text-brandBlue flex items-center gap-1 group/link">
                    Lihat Semua 
                    <span class="material-symbols-outlined text-[16px] transition-transform group-hover/link:translate-x-1">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-display font-bold text-[#111318]">Status Pesanan Terkini</h3>
            <a href="{{ route('customer.orders') }}" class="text-sm font-medium text-gray-500 hover:text-brandBlue">Lihat Semua</a>
        </div>
        <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-medium">Produk</th>
                            <th scope="col" class="px-6 py-4 font-medium">No. Pesanan</th>
                            <th scope="col" class="px-6 py-4 font-medium">Tanggal</th>
                            <th scope="col" class="px-6 py-4 font-medium">Status</th>
                            <th scope="col" class="px-6 py-4 font-medium text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @php $firstItem = $order->items->first(); @endphp
                                        <div class="w-12 h-16 rounded overflow-hidden bg-gray-100 flex-shrink-0">
                                            @if($firstItem && $firstItem->product && $firstItem->product->image_main)
                                                <img 
                                                    src="{{ asset('storage/' . $firstItem->product->image_main) }}" 
                                                    alt="{{ $firstItem->product_name }}" 
                                                    class="w-full h-full object-cover" 
                                                />
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                                    <span class="material-symbols-outlined text-[20px]">image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium text-[#111318]">
                                                @if($firstItem)
                                                    {{ $firstItem->product_name }}
                                                @else
                                                    Pesanan #{{ $order->id }}
                                                @endif
                                            </p>
                                            @if($order->items->count() > 1)
                                                <p class="text-xs text-gray-500 text-nowrap">+ {{ $order->items->count() - 1 }} produk lainnya</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium">#{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide
                                        {{ $order->status === 'Dikirim' ? 'bg-blue-50 text-blue-600' : 
                                           ($order->status === 'Selesai' ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-600') }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-brandBlue">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada pesanan terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recommended -->
    <div>
        <h3 class="text-xl font-display font-bold text-[#111318] mb-6">Rekomendasi Untuk Anda</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($recommendedProducts as $product)
                <div class="group cursor-pointer bg-white rounded-2xl border-2 border-[#5D4037] p-2 transition-all hover:shadow-xl hover:-translate-y-1">
                    <div class="relative overflow-hidden rounded-xl aspect-[3/4] mb-2 bg-gray-100">
                        <img 
                            src="{{ asset('storage/' . $product->image_main) }}" 
                            alt="{{ $product->product_name }}" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                        />
                        
                        <button class="absolute top-2 right-2 p-1.5 bg-white/80 hover:bg-white rounded-full text-[#111318] transition-colors opacity-0 group-hover:opacity-100 shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">favorite</span>
                        </button>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-white/90 backdrop-blur-sm">
                            <a href="{{ route('products.show', $product->id) }}" class="flex w-full items-center justify-center py-1.5 bg-[#111318] text-white text-xs font-bold uppercase tracking-wider rounded-lg hover:bg-black transition-colors">
                                Lihat
                            </a>
                        </div>
                    </div>
                    
                    <div class="px-1">
                        <h4 class="font-display font-bold text-sm text-[#111318] group-hover:text-brandBlue transition-colors line-clamp-1">
                            {{ $product->product_name }}
                        </h4>
                        
                        <div class="flex items-center gap-2 mt-0.5">
                            <p class="font-serif text-xs font-medium {{ $product->on_sale ? 'text-brandRed' : 'text-gray-600' }}">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
