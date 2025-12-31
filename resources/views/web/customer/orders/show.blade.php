@extends('web.customer.layouts.app')

@section('header_title', 'Lacak Pesanan')
@section('header_subtitle', 'Pantau perjalanan pesanan Anda hingga sampai ke tujuan.')

@section('customer_content')
<div class="space-y-8 animate-fade-in">
    {{-- Breadcrumbs --}}
    <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gray-400 mb-6">
        <a href="{{ route('customer.dashboard') }}" class="hover:text-brandBlue transition-colors">Dashboard</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a href="{{ route('customer.orders') }}" class="hover:text-brandBlue transition-colors">Riwayat Pesanan</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-brandBlue">#{{ $order->order_number }}</span>
    </nav>

    {{-- Header Section --}}
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden group">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 relative z-10">
            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <h1 class="font-serif text-3xl md:text-4xl font-bold text-[#111318]">Pesanan #{{ $order->order_number }}</h1>
                    <span class="px-4 py-1.5 rounded-full bg-brandBlue/10 text-[10px] font-bold uppercase tracking-widest text-brandBlue border border-brandBlue/20">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <p class="text-gray-500 italic font-light">
                    Dipesan pada <span class="font-bold text-[#111318] not-italic">{{ $order->created_at->format('d M Y') }}</span> pukul <span class="not-italic">{{ $order->created_at->format('H:i') }} WIB</span>
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                @if(in_array($order->status, ['shipped', 'out_for_delivery']))
                    <form action="{{ route('customer.orders.complete', $order->id) }}" method="POST" id="complete-order-form">
                        @csrf
                        <button type="button" onclick="confirmComplete()" class="flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-green-600 text-white hover:bg-green-700 text-xs font-bold uppercase tracking-widest transition-all shadow-lg shadow-green-600/20">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                            Pesanan Diterima
                        </button>
                    </form>
                @endif
                <a href="{{ route('customer.orders.invoice', $order->id) }}" class="flex items-center gap-2 px-6 py-3.5 rounded-2xl border border-gray-100 bg-white hover:bg-gray-50 text-[#111318] text-xs font-bold uppercase tracking-widest transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Download Invoice
                </a>
                <button class="flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-black text-white hover:bg-brandBlue text-xs font-bold uppercase tracking-widest transition-all shadow-lg shadow-black/10">
                    <span class="material-symbols-outlined text-[18px]">support_agent</span>
                    Hubungi CS
                </button>
            </div>
        </div>
        
        <div class="absolute right-0 top-0 size-48 bg-gray-50/50 rounded-bl-[6rem] -z-0 group-hover:bg-brandBlue/5 transition-colors"></div>
    </div>

    {{-- Tracking Progress --}}
    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-gray-100 shadow-sm">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-12 gap-4">
            <div>
                <h2 class="font-serif text-2xl font-bold text-[#111318]">Status Pengiriman</h2>
                <p class="text-gray-400 text-sm italic font-light mt-1">Estimasi kedatangan: <span class="font-bold text-brandBlue not-italic">{{ $order->tracking->estimatedArrival }}</span></p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-2xl border border-gray-100">
                <span class="material-symbols-outlined text-brandBlue text-[20px]">location_on</span>
                <span class="text-xs font-bold text-[#111318]">{{ $order->tracking->currentLocation }}</span>
            </div>
        </div>

        {{-- Stepper --}}
        <div class="relative px-4">
            {{-- Connector Line --}}
            <div class="absolute left-8 md:left-4 top-0 bottom-0 md:top-4 md:bottom-auto md:left-0 md:right-0 h-full md:h-1 bg-gray-100 -z-0">
                <div class="h-1/2 md:h-full md:w-1/2 bg-brandBlue transition-all duration-1000"></div>
            </div>

            <div class="relative z-10 grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-4">
                @foreach($order->tracking->steps as $index => $step)
                    <div class="flex md:flex-col items-center gap-4 text-center">
                        <div class="size-10 rounded-full flex items-center justify-center transition-all duration-500 shadow-sm
                            {{ $step->completed ? 'bg-brandBlue text-white border-4 border-white ring-1 ring-brandBlue' : 
                               (isset($step->isCurrent) && $step->isCurrent ? 'bg-white text-brandBlue border-4 border-brandBlue animate-pulse' : 'bg-white text-gray-300 border-4 border-gray-100') }}">
                            @if($step->completed)
                                <span class="material-symbols-outlined text-[18px] font-bold">check</span>
                            @else
                                <span class="text-xs font-bold">{{ $index + 1 }}</span>
                            @endif
                        </div>
                        <div class="flex flex-col md:items-center text-left md:text-center">
                            <h4 class="text-sm font-bold uppercase tracking-wider {{ $step->completed || (isset($step->isCurrent) && $step->isCurrent) ? 'text-[#111318]' : 'text-gray-300' }}">
                                {{ $step->label }}
                            </h4>
                            @if(isset($step->date))
                                <p class="text-[10px] text-gray-400 font-bold mt-1 italic">{{ $step->date }}, {{ $step->time }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Product Details --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-50">
                    <h2 class="font-serif text-2xl font-bold text-[#111318]">Item Pesanan</h2>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $order->items->count() }} Produk</span>
                </div>

                <div class="space-y-8">
                    @foreach($order->items as $index => $item)
                        <div class="flex gap-6 items-start group">
                            <div class="size-24 md:size-32 rounded-2xl overflow-hidden bg-gray-50 flex-shrink-0 border border-gray-100 group-hover:scale-105 transition-transform duration-500">
                                <img src="{{ $item->product->image_main ? Storage::url($item->product->image_main) : 'https://via.placeholder.com/300' }}" alt="{{ $item->product->product_name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 flex flex-col md:flex-row justify-between gap-4">
                                <div class="space-y-1">
                                    <h3 class="font-serif text-lg font-bold text-[#111318] group-hover:text-brandBlue transition-colors">{{ $item->product->product_name }}</h3>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest flex items-center gap-2">
                                        {{ $item->variant?->color ?? '-' }} <span class="size-1 rounded-full bg-gray-200"></span> {{ $item->variant?->size ?? '-' }}
                                    </p>
                                    <div class="mt-3 inline-flex px-3 py-1 bg-gray-50 rounded-lg text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                        SKU: {{ $item->variant?->sku ?? $item->product->id }}
                                    </div>
                                </div>
                                <div class="flex flex-col items-start md:items-end">
                                    <p class="text-sm font-bold text-gray-400">Rp {{ number_format($item->price, 0, ',', '.') }} <span class="text-[10px] font-normal italic">x{{ $item->quantity }}</span></p>
                                    <p class="text-lg font-bold text-brandBlue">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div class="h-px bg-gray-50 w-full"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Help Banner --}}
            <div class="bg-black rounded-[2.5rem] p-8 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative group">
                <div class="relative z-10 text-center md:text-left">
                    <h4 class="text-white font-serif text-xl font-bold italic">Butuh bantuan dengan pesanan ini?</h4>
                    <p class="text-gray-400 text-sm font-light mt-1">Tim layanan pelanggan kami siap membantu Anda 24/7.</p>
                </div>
                <button class="relative z-10 px-8 py-4 rounded-2xl bg-white text-black text-xs font-bold uppercase tracking-widest hover:bg-brandBlue hover:text-white transition-all shadow-xl">
                    Hubungi Bantuan
                </button>
                <div class="absolute -right-10 -bottom-10 size-48 bg-white/5 rounded-full blur-3xl group-hover:bg-brandBlue/10 transition-colors"></div>
            </div>
        </div>

        {{-- Right Column: Summary & Info --}}
        <div class="space-y-8">
            {{-- Payment Summary --}}
            <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm relative overflow-hidden group">
                <h2 class="font-serif text-xl font-bold text-[#111318] mb-6">Ringkasan Pembayaran</h2>
                
                <div class="space-y-4 pb-6 border-b border-gray-100">
                    <div class="flex justify-between text-sm italic font-light">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-bold text-[#111318]">Rp {{ number_format($order->summary->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm italic font-light">
                        <span class="text-gray-500">Pengiriman</span>
                        <span class="font-bold text-[#111318]">Rp {{ number_format($order->summary->shipping, 0, ',', '.') }}</span>
                    </div>
                    @if($order->summary->discount > 0)
                        <div class="flex justify-between text-sm italic font-light">
                            <span class="text-gray-500">Diskon</span>
                            <span class="font-bold text-brandRed">- Rp {{ number_format($order->summary->discount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-sm italic font-light">
                        <span class="text-gray-500">Pajak (11%)</span>
                        <span class="font-bold text-[#111318]">Rp {{ number_format($order->summary->tax, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="pt-6 flex justify-between items-center mb-6">
                    <span class="text-lg font-serif font-bold text-[#111318] italic">Total</span>
                    <span class="text-2xl font-serif font-bold text-brandBlue">Rp {{ number_format($order->summary->total, 0, ',', '.') }}</span>
                </div>

                <div class="p-3 bg-green-50 rounded-2xl border border-green-100 text-center group-hover:bg-green-100 transition-colors">
                    <span class="text-[10px] font-bold text-green-600 uppercase tracking-[0.2em]">{{ $order->summary->status }}</span>
                </div>
            </div>

            {{-- Shipping & Payment Info --}}
            <div class="bg-[#111318] rounded-[2.5rem] p-8 text-white space-y-8">
                {{-- Shipping --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="size-10 rounded-2xl bg-white/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-[20px]">local_shipping</span>
                        </div>
                        <h3 class="font-serif text-lg font-bold italic">Info Pengiriman</h3>
                    </div>
                    <div class="space-y-4 pl-1">
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mb-1">Penerima</p>
                            <p class="text-sm font-bold">{{ $order->shippingAddress->recipient_name }}</p>
                            <p class="text-xs text-gray-500 font-light italic mt-0.5">{{ $order->shippingAddress->phone_number }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mb-1">Alamat</p>
                            <p class="text-sm text-gray-400 font-light leading-relaxed italic">
                                {{ $order->shippingAddress->address_line }},<br>
                                {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->province }},<br>
                                {{ $order->shippingAddress->postal_code }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 bg-white/10 px-3 py-1 rounded-lg w-fit font-bold tracking-widest">
                                {{ $order->shipping_method }}
                            </p>
                            <p class="text-[10px] text-gray-500 font-bold mt-2 uppercase tracking-widest">Resi: <span class="text-white">BELUM TERSEDIA</span></p>
                        </div>
                    </div>
                </div>

                <div class="h-px bg-white/10 w-full"></div>

                {{-- Payment --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="size-10 rounded-2xl bg-white/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-[20px]">payments</span>
                        </div>
                        <h3 class="font-serif text-lg font-bold italic">Metode Pembayaran</h3>
                    </div>
                    <div class="pl-1">
                        <p class="text-sm font-bold">{{ $order->payment_method }}</p>
                        <p class="text-[10px] text-gray-500 font-bold mt-1 uppercase tracking-widest">{{ $order->payment_status === 'paid' ? 'DIKONFIRMASI' : 'MENUNGGU PEMBAYARAN' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmComplete() {
    Swal.fire({
        title: 'Konfirmasi Penerimaan',
        text: 'Apakah Anda yakin pesanan sudah diterima dengan baik?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Sudah Diterima',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-2xl font-sans',
            title: 'font-serif italic font-bold text-lg',
            confirmButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-widest text-[10px]',
            cancelButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-widest text-[10px]'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('complete-order-form').submit();
        }
    });
}
</script>
@endpush
@endsection
