@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Maneé Admin')

@section('content')
<div class="max-w-[1200px] mx-auto flex flex-col gap-6">
    {{-- Breadcrumbs --}}
    <div class="flex flex-wrap gap-2 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-blue-600 font-medium transition-colors">Dashboard</a>
        <span class="text-slate-400">/</span>
        <a href="{{ route('admin.orders.index') }}" class="text-slate-500 hover:text-blue-600 font-medium transition-colors">Pesanan</a>
        <span class="text-slate-400">/</span>
        <span class="text-slate-900 dark:text-white font-medium">Detail Pesanan #{{ $order->order_number }}</span>
    </div>

    {{-- Page Header --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-4">
        <div class="flex flex-col gap-2">
            <h1 class="text-slate-900 dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-tight">
                Pesanan #{{ $order->order_number }}
            </h1>
            <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400 text-sm md:text-base flex-wrap">
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    <p>{{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
                <span class="hidden md:inline text-slate-300">•</span>
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                        'processing' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                        'shipped' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                        'out_for_delivery' => 'bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                        'completed' => 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                        'cancelled' => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                    ];
                    $statusColor = $statusColors[$order->status] ?? 'bg-slate-50 text-slate-700';
                @endphp
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider {{ $statusColor }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            {{-- Status Update Form --}}
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="flex items-center gap-3">
                @csrf
                @method('PUT')
                <div class="relative">
                    <select name="status" class="appearance-none min-w-[180px] bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 text-slate-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 block p-2.5 pr-10 cursor-pointer font-bold transition-all shadow-sm">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="out_for_delivery" {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}>Di Antar Kurir</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <span class="material-symbols-outlined text-[20px]">expand_more</span>
                    </div>
                </div>
                <button type="submit" class="h-10 px-4 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200/50">
                    Update
                </button>
            </form>
            
            <button class="flex items-center justify-center gap-2 rounded-xl bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-gray-700 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">print</span>
                <span>Faktur</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content Column --}}
        <div class="lg:col-span-2 flex flex-col gap-6">
            {{-- Order Items Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 dark:border-gray-700 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">Daftar Produk</h3>
                    <span class="px-3 py-1 bg-slate-100 dark:bg-gray-700 rounded-full text-xs font-bold text-slate-500 dark:text-slate-400">
                        {{ $order->items->count() }} Item
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50/50 dark:bg-gray-700/50 text-xs uppercase text-slate-500 font-bold overflow-hidden">
                            <tr>
                                <th class="px-6 py-4">Produk</th>
                                <th class="px-6 py-4 text-right">Harga</th>
                                <th class="px-6 py-4 text-center">Jumlah</th>
                                <th class="px-6 py-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-slate-50/30 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-xl border border-slate-100 dark:border-gray-600 bg-white">
                                                <img src="{{ $item->product->image_main ? Storage::url($item->product->image_main) : 'https://via.placeholder.com/100' }}" alt="{{ $item->product->product_name }}" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 dark:text-white">{{ $item->product->product_name }}</div>
                                                <div class="text-xs text-slate-500 font-medium">
                                                    {{ $item->variant?->color ?? 'Standar' }} / {{ $item->variant?->size ?? 'All Size' }}
                                                </div>
                                                <div class="text-[10px] text-slate-400 mt-1 uppercase tracking-tight">SKU: {{ $item->variant?->sku ?? $item->product->sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center font-bold">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right font-black text-slate-900 dark:text-white whitespace-nowrap">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Financial Summary --}}
                <div class="bg-slate-50/30 dark:bg-gray-700/20 px-6 py-8 border-t border-slate-100 dark:border-gray-700">
                    <div class="ml-auto w-full md:w-1/2 lg:w-6/12 space-y-4">
                        <div class="flex justify-between text-sm text-slate-600 dark:text-slate-400">
                            <span class="font-medium">Subtotal</span>
                            <span class="font-bold text-slate-900 dark:text-white">Rp {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-slate-600 dark:text-slate-400">
                            <span class="font-medium">Pengiriman ({{ $order->shipping_method }})</span>
                            <span class="font-bold text-slate-900 dark:text-white">Rp {{ number_format(15000, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-slate-600 dark:text-slate-400">
                            <span class="font-medium">Pajak (PPN 11%)</span>
                            <span class="font-bold text-slate-900 dark:text-white">Rp {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity) * 0.11, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-4 mt-2 border-t border-slate-200 dark:border-gray-600 flex justify-between items-center text-lg font-black text-slate-900 dark:text-white">
                            <span>Total Pembayaran</span>
                            <span class="text-blue-600 text-2xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Timeline Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 dark:border-gray-700 p-8 shadow-sm">
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-8">Riwayat Pesanan</h3>
                <div class="relative pl-6 border-l-2 border-slate-100 dark:border-gray-700 space-y-10">
                    {{-- Order Placed --}}
                    <div class="relative">
                        <div class="absolute -left-[33px] top-1.5 h-4 w-4 rounded-full ring-4 ring-white dark:ring-gray-800 bg-blue-600 shadow-sm shadow-blue-200"></div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
                        <p class="font-black text-slate-900 dark:text-white text-base">Pesanan Dibuat</p>
                        <p class="text-sm text-slate-500 mt-1">Sistem Maneé mencatat pesanan baru dari pelanggan.</p>
                    </div>

                    {{-- Payment Status --}}
                    <div class="relative">
                        <div class="absolute -left-[33px] top-1.5 h-4 w-4 rounded-full ring-4 ring-white dark:ring-gray-800 {{ $order->payment_status === 'paid' ? 'bg-green-500 shadow-green-100' : 'bg-slate-300 dark:bg-gray-600' }} shadow-sm"></div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">{{ $order->payment_status === 'paid' ? 'Terkonfirmasi' : 'Menunggu' }}</p>
                        <p class="font-black text-slate-900 dark:text-white text-base">Status Pembayaran: {{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}</p>
                        <p class="text-sm text-slate-500 mt-1">
                            {{ $order->payment_status === 'paid' ? 'Metode: ' . $order->payment_method : 'Menunggu konfirmasi pembayaran via ' . $order->payment_method }}
                        </p>
                    </div>

                    {{-- Processing Status --}}
                    <div class="relative">
                        <div class="absolute -left-[33px] top-1.5 h-4 w-4 rounded-full ring-4 ring-white dark:ring-gray-800 {{ !in_array($order->status, ['pending']) ? 'bg-blue-600 shadow-blue-100' : 'bg-slate-300 dark:bg-gray-600' }} shadow-sm"></div>
                        <p class="font-black text-slate-900 dark:text-white text-base">Pesanan Diproses</p>
                        <p class="text-sm text-slate-500 mt-1">Tim gudang sedang menyiapkan produk untuk pengiriman.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Column --}}
        <div class="flex flex-col gap-6">
            {{-- Customer Info Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Pelanggan</h3>
                    <a href="{{ route('admin.users.show', $order->user_id) }}" class="text-blue-600 text-xs font-bold hover:underline">Lihat Profil</a>
                </div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-14 w-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-black border-4 border-blue-50 dark:border-blue-900/30">
                        {{ strtoupper(substr($order->user->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="font-black text-slate-900 dark:text-white text-lg tracking-tight">{{ $order->user->name }}</div>
                        <div class="text-xs font-bold text-blue-600/70 uppercase">ID Pelanggan #{{ $order->user_id }}</div>
                    </div>
                </div>
                <div class="space-y-4 pt-6 border-t border-slate-100 dark:border-gray-700">
                    <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                        <span class="material-symbols-outlined text-[18px] text-slate-400">mail</span>
                        <a href="mailto:{{ $order->user->email }}" class="hover:text-blue-600 transition-colors font-medium">{{ $order->user->email }}</a>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                        <span class="material-symbols-outlined text-[18px] text-slate-400">call</span>
                        <a href="tel:{{ $order->shippingAddress->phone_number }}" class="hover:text-blue-600 transition-colors font-medium">{{ $order->shippingAddress->phone_number }}</a>
                    </div>
                </div>
            </div>

            {{-- Shipping Address Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Alamat Pengiriman</h3>
                    <span class="material-symbols-outlined text-slate-400 text-[20px]">local_shipping</span>
                </div>
                <div class="space-y-4">
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Penerima</span>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $order->shippingAddress->recipient_name }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Alamat Lengkap</span>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-medium">
                            {{ $order->shippingAddress->address_line }}<br/>
                            {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->province }}<br/>
                            {{ $order->shippingAddress->postal_code }}
                        </p>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Metode Pengiriman</h3>
                    </div>
                    <div class="flex items-center gap-3 px-3 py-2 bg-slate-50 dark:bg-gray-700/50 rounded-xl border border-slate-100 dark:border-gray-600">
                        <span class="material-symbols-outlined text-blue-600">local_shipping</span>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $order->shipping_method }}</span>
                    </div>
                </div>
            </div>

            {{-- Internal Notes Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-slate-200 dark:border-gray-700 p-6 shadow-sm">
                <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Catatan Internal</h3>
                <textarea 
                    class="w-full rounded-xl border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900 text-slate-900 dark:text-white text-sm p-4 focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 resize-none h-32 transition-all outline-none" 
                    placeholder="Tulis catatan rahasia untuk tim admin..." 
                >{{ $order->notes }}</textarea>
                <button class="mt-3 w-full rounded-xl bg-slate-900 dark:bg-blue-600 text-white font-bold py-3 text-sm hover:opacity-90 transition-all shadow-lg shadow-slate-200 dark:shadow-none">
                    Simpan Catatan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
