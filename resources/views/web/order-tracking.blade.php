@extends('layouts.web')

@section('title', 'Lacak Pesanan - Maneé Fashion Store')

@section('content')
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden font-body text-[#111318] bg-[#FCFCFC]">

    <section class="flex flex-1 flex-col items-center px-4 py-12 md:px-10 lg:py-20">
        <div class="flex w-full max-w-4xl flex-col gap-10">
            
            <!-- Page Heading & Search Form -->
            <div class="flex flex-col items-center text-center gap-6">
                <div class="space-y-2">
                    <h1 class="font-display text-4xl font-bold tracking-tight text-[#111318] md:text-5xl">
                        Lacak Pesanan Anda
                    </h1>
                    <p class="text-gray-500 max-w-lg mx-auto">
                        Pantau perjalanan paket Maneé Anda dari gudang kami hingga ke tangan Anda. Masukkan nomor pesanan untuk memulai.
                    </p>
                </div>

                <div class="w-full max-w-xl">
                    <form action="{{ route('order.tracking') }}" method="GET" class="relative flex items-center shadow-lg shadow-gray-200/50 rounded-xl bg-white p-2 border border-gray-100">
                        <span class="material-symbols-outlined absolute left-4 text-gray-400">
                            tag
                        </span>
                        <input
                            type="text"
                            name="order_number"
                            value="{{ request('order_number') }}"
                            class="h-14 w-full flex-1 border-none bg-transparent pl-12 pr-4 text-base text-[#111318] placeholder:text-gray-400 focus:ring-0 focus:outline-none"
                            placeholder="Contoh: MN-231024-XXXXXX"
                            required
                        />
                        <button 
                            type="submit"
                            class="h-12 shrink-0 rounded-lg bg-brandBlue px-6 font-medium text-white shadow-md shadow-brandBlue/30 hover:bg-opacity-90 transition-all active:scale-95 flex items-center justify-center min-w-[100px]"
                        >
                            Lacak
                        </button>
                    </form>
                </div>
            </div>

            @if(isset($message))
                <div class="w-full max-w-xl mx-auto p-4 bg-red-50 text-red-600 rounded-lg text-center font-medium border border-red-100">
                    {{ $message }}
                </div>
            @endif

            <!-- Tracking Result -->
            @if(isset($order) && $order)
                <div class="w-full max-w-4xl animate-fade-in-up">
                    
                    <div class="overflow-hidden rounded-2xl bg-white shadow-xl shadow-gray-200/60 border border-gray-100">
                        
                        <!-- Status Header -->
                        <div class="flex flex-col md:flex-row justify-between p-6 md:p-8 bg-gray-50 border-b border-gray-100 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Nomor Pesanan
                                </p>
                                <p class="text-2xl font-bold font-display text-[#111318] mt-1">
                                    #{{ $order->order_number }}
                                </p>
                            </div>
                            <div class="md:text-right">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Estimasi Tiba
                                </p>
                                <p class="text-xl font-bold text-brandBlue mt-1">
                                    {{ $order->tracking->estimatedArrival }}
                                </p>
                                <p class="text-sm text-gray-400">
                                    Dikirim via {{ $order->shipping_method ?? 'Standar' }}
                                </p>
                            </div>
                        </div>

                        <!-- Progress Stepper -->
                        <div class="px-6 py-8 md:px-12">
                            <div class="relative flex flex-col md:flex-row justify-between w-full">
                                @php
                                    $steps = $order->tracking->steps;
                                    $completedCount = count(array_filter($steps, fn($s) => $s->completed));
                                    $progressPercent = ($completedCount - 1) / (count($steps) - 1) * 100;
                                @endphp

                                <!-- Connecting Lines Keyframe -->
                                <div class="absolute top-5 left-0 h-1 w-full bg-gray-100 hidden md:block"></div>
                                <div 
                                    class="absolute top-5 left-0 h-1 bg-brandLightBlue hidden md:block transition-all duration-1000"
                                    style="width: {{ $progressPercent }}%" 
                                ></div>
                                
                                <div class="absolute left-5 top-0 w-1 h-full bg-gray-100 md:hidden"></div>
                                <div 
                                    class="absolute left-5 top-0 w-1 bg-brandLightBlue md:hidden"
                                    style="height: {{ $progressPercent }}%"
                                ></div>

                                <!-- Steps -->
                                @foreach($steps as $index => $step)
                                    <div class="relative z-10 flex md:flex-col items-center gap-4 md:gap-2 mb-6 md:mb-0 last:mb-0">
                                        <div 
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full shadow-lg ring-4 ring-white transition-all duration-300 {{ $step->completed ? 'bg-brandBlue text-white' : 'bg-gray-200 text-gray-400' }}"
                                        >
                                            <span class="material-symbols-outlined text-sm font-bold">
                                                {{ $index == 0 ? 'shopping_bag' : ($index == 1 ? 'inventory_2' : ($index == 2 ? 'local_shipping' : 'home')) }}
                                            </span>
                                        </div>
                                        <div class="flex flex-col md:items-center">
                                            <p class="text-sm font-bold {{ $step->completed ? 'text-brandBlue' : 'text-[#111318]' }}">
                                                {{ $step->label }}
                                            </p>
                                            @if(isset($step->date))
                                                <p class="text-xs text-gray-500">
                                                    {{ $step->date }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 border-t border-gray-100">
                            
                            <!-- Timeline Section (Simplified from Accessor) -->
                            <div class="md:col-span-2 p-6 md:p-8 border-b md:border-b-0 md:border-r border-gray-100">
                                <h3 class="font-display text-xl font-bold text-[#111318] mb-6">
                                    Status Terkini
                                </h3>
                                <div class="space-y-6 relative pl-2">
                                    <div class="absolute left-[15px] top-2 bottom-2 w-[2px] bg-gray-100"></div>
                                    
                                    <div class="relative flex gap-4">
                                        <div class="absolute -left-1 mt-1.5 h-3 w-3 rounded-full ring-4 ring-white bg-brandBlue"></div>
                                        <div class="pl-4">
                                            <p class="text-sm font-bold text-[#111318]">
                                                {{ $order->tracking->currentLocation }}
                                            </p>
                                            <p class="text-xs text-gray-500 mb-1">Update Terakhir</p>
                                            <p class="text-xs font-medium text-gray-400">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Info Section -->
                            <div class="p-6 md:p-8 bg-gray-50/50">
                                <h3 class="font-display text-xl font-bold text-[#111318] mb-6">
                                    Item Pesanan ({{ $order->items->count() }})
                                </h3>
                                
                                <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                                    @foreach($order->items as $item)
                                    <div class="flex gap-4 items-start">
                                        <div class="h-16 w-14 shrink-0 overflow-hidden rounded-lg bg-gray-200">
                                            @php
                                                $imagePath = $item->product && $item->product->images->count() > 0 
                                                    ? asset('storage/' . $item->product->images->first()->image_path) 
                                                    : asset('images/product-placeholder.png');
                                            @endphp
                                            <img 
                                                src="{{ $imagePath }}" 
                                                alt="{{ $item->product_name }}"
                                                class="h-full w-full object-cover" 
                                            />
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-[#111318] leading-tight line-clamp-2">{{ $item->product_name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }}</p>
                                            <p class="text-sm font-medium text-[#111318] mt-1">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="mt-8 pt-6 border-t border-gray-200">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brandLightBlue/30 text-brandBlue">
                                            <span class="material-symbols-outlined text-[20px]">
                                                support_agent
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-[#111318]">
                                                Butuh Bantuan?
                                            </p>
                                            <a href="#" class="text-xs text-brandBlue hover:underline">
                                                Hubungi CS Kami
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>
</div>
@endsection
