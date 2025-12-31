@extends('web.customer.layouts.app')

@section('header_title', 'Riwayat Pesanan')
@section('header_subtitle', 'Pantau status dan detail pesanan Anda.')

@section('customer_content')
<div class="space-y-8">
    {{-- Header & Stats --}}
    <div class="flex flex-col md:flex-row gap-6 items-start md:items-center justify-between mb-8">
        <div>
            <h3 class="font-serif text-3xl font-bold text-[#111318]">
                Semua Pesanan
            </h3>
            <p class="text-gray-400 text-sm italic font-light mt-1">
                Menampilkan {{ $orders->count() }} pesanan terakhir Anda.
            </p>
        </div>
        <div class="flex gap-2 w-full md:w-auto">
            <button class="flex-1 md:flex-none px-6 py-3 rounded-2xl border border-gray-100 bg-white text-xs font-bold text-gray-400 hover:text-brandBlue hover:border-brandBlue/30 transition-all flex items-center justify-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">filter_list</span>
                Filter
            </button>
            <button class="flex-1 md:flex-none px-6 py-3 rounded-2xl border border-gray-100 bg-white text-xs font-bold text-gray-400 hover:text-brandBlue hover:border-brandBlue/30 transition-all flex items-center justify-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">search</span>
                Cari
            </button>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="grid grid-cols-1 gap-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-[2rem] border border-gray-100 p-6 md:p-8 shadow-sm hover:shadow-xl hover:border-brandBlue/20 transition-all group relative overflow-hidden">
                    {{-- Status Badge --}}
                    <div class="absolute top-0 right-0 mt-8 mr-8">
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest
                            {{ in_array($order->status, ['shipped', 'completed']) ? 'bg-blue-50 text-blue-600 border border-blue-100' : 
                               ($order->status === 'cancelled' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-gray-50 text-gray-600 border border-gray-100') }}">
                            <span class="size-1.5 rounded-full {{ in_array($order->status, ['shipped', 'completed']) ? 'bg-blue-600' : ($order->status === 'cancelled' ? 'bg-red-600' : 'bg-gray-600') }}"></span>
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        {{-- Product Thumbnail --}}
                        <div class="size-24 md:size-32 rounded-2xl overflow-hidden bg-gray-50 flex-shrink-0 border border-gray-100 group-hover:scale-105 transition-transform duration-500">
                            <img src="{{ $order->items->first()?->product?->image_main ? Storage::url($order->items->first()->product->image_main) : 'https://via.placeholder.com/300' }}" alt="Order Thumbnail" class="w-full h-full object-cover">
                        </div>

                        {{-- Order Info --}}
                        <div class="flex-1 space-y-4">
                            <div>
                                <h4 class="text-xl font-serif font-bold text-[#111318] group-hover:text-brandBlue transition-colors">Pesanan #{{ $order->order_number }}</h4>
                                <p class="text-gray-400 text-sm mt-1 flex items-center gap-4">
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">calendar_today</span> {{ $order->created_at->format('d M Y') }}</span>
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">schedule</span> {{ $order->created_at->format('H:i') }} WIB</span>
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-x-8 gap-y-2">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.2em] mb-1">Total Pesanan</p>
                                    <p class="text-lg font-bold text-brandBlue">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.2em] mb-1">Jumlah Item</p>
                                    <p class="text-sm font-bold text-[#111318] flex items-center gap-2">
                                        {{ $order->items->sum('quantity') }} Items
                                        <span class="size-1.5 rounded-full bg-gray-200"></span>
                                        <span class="text-xs text-gray-400 font-light italic">Lihat Detail</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex md:flex-col gap-3 w-full md:w-auto pt-4 md:pt-0">
                            <a href="{{ route('customer.orders.show', $order->id) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-brandBlue transition-all shadow-lg shadow-black/10">
                                <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                                Lacak
                            </a>
                            @if($order->status === 'completed')
                                <a href="{{ route('reviews.index', ['order_id' => $order->id]) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-amber-500 text-white text-xs font-bold uppercase tracking-widest hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/20">
                                    <span class="material-symbols-outlined text-[18px]">star</span>
                                    Beri Penilaian
                                </a>
                            @else
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl border border-gray-100 bg-white text-xs font-bold uppercase tracking-widest text-[#111318] hover:bg-gray-50 transition-all">
                                    Detail
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Decorative Element --}}
                    <div class="absolute -bottom-6 -right-6 size-24 bg-gray-50/50 rounded-full -z-0 group-hover:bg-brandBlue/5 transition-colors"></div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden min-h-[400px] flex flex-col items-center justify-center p-12 text-center">
            <div class="size-24 rounded-full bg-gray-50 flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-5xl text-gray-200">orders</span>
            </div>
            <h4 class="text-xl font-serif font-bold text-[#111318] mb-2 italic">Belum Ada Pesanan</h4>
            <p class="text-gray-400 max-w-xs mx-auto mb-8 font-light italic">
                Anda belum melakukan pemesanan apapun. Temukan koleksi terbaik kami di toko.
            </p>
            <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 bg-black text-white px-8 py-4 rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-brandBlue transition-all shadow-lg shadow-black/10">
                Mulai Belanja <span class="material-symbols-outlined text-[18px]">keyboard_arrow_right</span>
            </a>
        </div>
    @endif
</div>
@endsection
