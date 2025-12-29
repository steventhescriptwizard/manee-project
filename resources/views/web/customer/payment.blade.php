@extends('web.customer.layouts.app')

@section('header_title', 'Metode Pembayaran')
@section('header_subtitle', 'Kelola kartu dan pilihan pembayaran Anda untuk transaksi yang lebih mudah.')

@section('customer_content')
<div class="space-y-8 animate-fade-in">
    {{-- Header & Add Button --}}
    <div class="flex flex-col md:flex-row gap-6 items-start md:items-center justify-between mb-8">
        <div>
            <h3 class="font-serif text-3xl font-bold text-[#111318]">
                Kartu & Dompet
            </h3>
            <p class="text-gray-400 text-sm italic font-light mt-1">
                Data pembayaran Anda dienkripsi dan aman.
            </p>
        </div>
        <button class="w-full md:w-auto px-8 py-4 rounded-2xl bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-brandBlue transition-all shadow-lg shadow-black/10 flex items-center justify-center gap-2 group">
            <span class="material-symbols-outlined text-[20px] group-hover:rotate-180 transition-transform">add_card</span>
            Tambah Metode Baru
        </button>
    </div>

    {{-- Payment Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Credit Card (Mockup) --}}
        <div class="bg-gradient-to-br from-[#111318] to-[#2c313a] rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group min-h-[220px] flex flex-col justify-between">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-10">
                    <div class="flex items-center gap-3">
                        <div class="size-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-md">
                            <span class="material-symbols-outlined text-white">credit_card</span>
                        </div>
                        <h4 class="font-serif text-lg font-bold italic">Primary Card</h4>
                    </div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" class="h-4 opacity-80">
                </div>
                
                <div class="space-y-4">
                    <p class="text-xl font-bold tracking-[0.2em] mb-1">**** **** **** 8892</p>
                    <div class="flex gap-8">
                        <div>
                            <p class="text-[8px] text-gray-500 uppercase font-bold tracking-widest mb-1">Exp Date</p>
                            <p class="text-xs font-bold">12 / 26</p>
                        </div>
                        <div>
                            <p class="text-[8px] text-gray-500 uppercase font-bold tracking-widest mb-1">Card Holder</p>
                            <p class="text-xs font-bold uppercase">{{ $user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center relative z-10 pt-6">
                 <span class="px-3 py-1 rounded-full bg-white/20 text-[9px] font-bold uppercase tracking-widest backdrop-blur-md">Utama</span>
                 <button class="text-gray-400 hover:text-white transition-colors">
                     <span class="material-symbols-outlined text-[20px]">delete</span>
                 </button>
            </div>
            
            <!-- Abstract pattern deco -->
            <div class="absolute -right-10 -bottom-10 size-48 bg-white/5 rounded-full blur-3xl group-hover:bg-brandBlue/10 transition-colors"></div>
            <div class="absolute top-0 right-0 p-8 opacity-10">
                 <span class="material-symbols-outlined text-8xl">contactless</span>
            </div>
        </div>

        {{-- E-Wallet (Mockup) --}}
        <div class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm hover:border-brandBlue/20 hover:shadow-xl transition-all relative overflow-hidden group flex flex-col justify-between">
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-10">
                        <div class="flex items-center gap-4">
                            <div class="size-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-brandBlue/5 group-hover:text-brandBlue transition-colors">
                                <span class="material-symbols-outlined text-[24px]">account_balance_wallet</span>
                            </div>
                            <h4 class="text-xl font-serif font-bold text-[#111318]">GOPAY</h4>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full border border-green-100">Terhubung</span>
                    </div>

                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.2em] mb-1">Nomor Terhubung</p>
                        <p class="font-bold text-[#111318] text-lg italic">0812 **** 7890</p>
                    </div>
                </div>

                <div class="flex gap-4 mt-10">
                    <button class="flex-1 px-4 py-3 rounded-xl border border-gray-100 bg-white text-[10px] font-bold uppercase tracking-widest text-[#111318] hover:bg-gray-50 transition-all">
                        Atur Limit
                    </button>
                    <button class="px-4 py-3 rounded-xl border border-gray-100 bg-white text-gray-400 hover:text-brandRed hover:border-brandRed/20 transition-all">
                        Putuskan
                    </button>
                </div>
            </div>
            <div class="absolute -right-6 -bottom-6 size-24 bg-gray-50 rounded-full -z-0 group-hover:bg-brandBlue/5 transition-colors"></div>
        </div>
    </div>
</div>
@endsection
