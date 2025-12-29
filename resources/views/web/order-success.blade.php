@extends('layouts.web')

@section('title', 'Order Confirmed - Maneé')

@section('content')
<main class="flex-grow container mx-auto px-6 py-12 lg:py-20 mt-20 animate-fade-in">
    <div class="max-w-4xl mx-auto bg-white p-8 md:p-16 shadow-2xl border border-gray-100 rounded-[3rem] text-center relative overflow-hidden">
        {{-- Decorative element --}}
        <div class="absolute -top-20 -right-20 size-64 bg-brandBlue/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 size-64 bg-brandBlue/5 rounded-full blur-3xl"></div>

        <div class="w-20 h-20 bg-green-50 rounded-3xl flex items-center justify-center mx-auto mb-8 text-green-500 shadow-lg shadow-green-100 relative z-10">
            <span class="material-symbols-outlined text-4xl">check_circle</span>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-serif italic font-bold text-[#111318] mb-6 leading-tight relative z-10">
            Terima Kasih Atas<br>Pesanan Anda!
        </h1>
        <p class="text-gray-400 font-light text-lg max-w-lg mx-auto mb-12 italic relative z-10">
            Pesanan Anda telah kami terima dan sedang diproses. Kami telah mengirimkan detail konfirmasi ke email Anda.
        </p>

        <div class="bg-gray-50 p-10 rounded-[2.5rem] mb-12 relative z-10 border border-gray-100 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-left">
                <div class="border-b md:border-b-0 md:border-r border-gray-200 pb-6 md:pb-0 md:pr-6">
                    <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] mb-3 font-bold">Nomor Pesanan</p>
                    <p class="font-bold text-2xl text-[#111318] italic font-serif">#{{ session('order_number') }}</p>
                </div>
                <div class="border-b md:border-b-0 md:border-r border-gray-200 pb-6 md:pb-0 md:pr-6">
                    <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] mb-3 font-bold">Tanggal</p>
                    <p class="font-bold text-xl text-[#111318] italic font-serif">{{ now()->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] mb-3 font-bold">Estimasi Tiba</p>
                    <p class="font-bold text-xl text-brandBlue italic font-serif">{{ now()->addDays(3)->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-6 max-w-2xl mx-auto relative z-10">
            @if(session('snap_token'))
                <button id="pay-button" class="block w-full bg-brandBlue text-white py-6 px-8 text-sm font-bold tracking-[0.2em] uppercase hover:bg-opacity-90 transition-all rounded-3xl shadow-2xl shadow-brandBlue/30 flex items-center justify-center gap-3 animate-bounce">
                    <span class="material-symbols-outlined">payments</span>
                    Bayar Sekarang
                </button>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                <a href="{{ route('home') }}" class="block w-full bg-[#111318] text-white py-5 px-8 text-xs font-bold tracking-[0.2em] uppercase hover:bg-brandBlue transition-all rounded-2xl shadow-2xl shadow-black/10 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                    Lanjut Belanja
                </a>
                <a href="{{ route('customer.orders') }}" class="block w-full border-2 border-gray-100 text-[#111318] py-5 px-8 text-xs font-bold tracking-[0.2em] uppercase hover:border-brandBlue/30 hover:bg-gray-50 transition-all rounded-2xl flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                    Lacak Pesanan
                </a>
            </div>
        </div>

        @if(session('snap_token'))
            <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
            <script type="text/javascript">
                const payButton = document.getElementById('pay-button');
                payButton.onclick = function () {
                    window.snap.pay('{{ session('snap_token') }}', {
                        onSuccess: function (result) {
                            window.location.href = "{{ route('customer.orders') }}?status=success";
                        },
                        onPending: function (result) {
                            window.location.href = "{{ route('customer.orders') }}?status=pending";
                        },
                        onError: function (result) {
                            window.location.href = "{{ route('customer.orders') }}?status=error";
                        }
                    });
                };
            </script>
        @endif
        
        <p class="mt-12 text-[10px] text-gray-400 uppercase tracking-[0.2em] font-bold italic">
            Butuh bantuan? <a href="#" class="text-brandBlue hover:underline">Hubungi Customer Service Kami</a>
        </p>
    </div>
</main>
@endsection
