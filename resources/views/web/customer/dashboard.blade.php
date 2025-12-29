@extends('web.customer.layouts.app')

@section('header_title', 'Dashboard')
@section('header_subtitle', 'Selamat datang kembali, ' . $user->name)

@section('customer_content')
<div class="space-y-10 animate-fade-in">
    <!-- Welcome Card -->
    <div class="bg-[#111318] text-white p-10 rounded-[2rem] shadow-2xl shadow-black/10 relative overflow-hidden group">
        <div class="relative z-10">
            <h2 class="text-3xl md:text-4xl font-serif font-bold mb-3 italic">
                Halo, {{ $user->name }}
            </h2>
            <p class="text-gray-400 text-sm md:text-base font-light tracking-wide uppercase">
                Member sejak {{ $user->created_at->format('F Y') }}
            </p>
            
            <div class="mt-8 flex flex-wrap gap-4">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest bg-white/10 text-white border border-white/10 backdrop-blur-md">
                    <span class="material-symbols-outlined text-[16px] fill-1 text-amber-400">workspace_premium</span>
                    Gold Member
                </span>
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest bg-brandBlue text-white shadow-lg shadow-brandBlue/20">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    Akun Terverifikasi
                </span>
            </div>
        </div>
        
        <!-- Decoration -->
        <div class="absolute -right-20 -top-20 size-64 bg-brandBlue/20 rounded-full blur-[80px] group-hover:bg-brandBlue/30 transition-all duration-700"></div>
        <div class="absolute -left-20 -bottom-20 size-64 bg-white/5 rounded-full blur-[60px]"></div>
    </div>

    <!-- Info Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Personal Info -->
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col justify-between hover:border-brandBlue/30 transition-all group relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="font-serif text-2xl font-bold text-[#111318]">
                        Informasi Pribadi
                    </h3>
                    <div class="size-12 rounded-2xl bg-gray-50 flex items-center justify-center group-hover:bg-brandBlue/10 transition-colors">
                        <span class="material-symbols-outlined text-gray-400 group-hover:text-brandBlue transition-colors">person</span>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase font-bold tracking-[0.2em] mb-1">Nama Lengkap</p>
                        <p class="font-bold text-[#111318] text-lg italic">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[10px] uppercase font-bold tracking-[0.2em] mb-1">Email</p>
                        <p class="font-bold text-[#111318] text-lg italic">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="mt-12 text-xs font-bold text-brandBlue hover:text-black flex items-center gap-2 transition-all uppercase tracking-widest relative z-10">
                <span>Edit Profil</span>
                <span class="material-symbols-outlined text-[18px]">arrow_right_alt</span>
            </a>
            
            <div class="absolute right-0 bottom-0 size-32 bg-gray-50/50 rounded-tl-[4rem] -z-0 group-hover:bg-brandBlue/5 transition-colors"></div>
        </div>

        <!-- Address Info -->
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col justify-between hover:border-brandBlue/30 transition-all group relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="font-serif text-2xl font-bold text-[#111318]">
                        Alamat Utama
                    </h3>
                    <div class="size-12 rounded-2xl bg-gray-50 flex items-center justify-center group-hover:bg-brandBlue/10 transition-colors">
                        <span class="material-symbols-outlined text-gray-400 group-hover:text-brandBlue transition-colors">home_pin</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="font-bold text-[#111318] text-lg italic">Rumah Utama</p>
                    <p class="text-gray-500 leading-relaxed font-light italic">
                        Belum ada alamat yang ditambahkan.<br>
                        Tambahkan alamat untuk mempermudah checkout.
                    </p>
                </div>
            </div>
            <a href="#" class="mt-12 text-xs font-bold text-brandBlue hover:text-black flex items-center gap-2 transition-all uppercase tracking-widest relative z-10">
                <span>Kelola Alamat</span>
                <span class="material-symbols-outlined text-[18px]">arrow_right_alt</span>
            </a>
            <div class="absolute right-0 bottom-0 size-32 bg-gray-50/50 rounded-tl-[4rem] -z-0 group-hover:bg-brandBlue/5 transition-colors"></div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
            <h3 class="font-serif text-2xl font-bold text-[#111318]">
                Pesanan Terakhir
            </h3>
            <a href="{{ route('customer.orders') }}" class="text-[10px] font-bold text-gray-400 hover:text-brandBlue uppercase tracking-widest transition-colors flex items-center gap-2">
                Lihat Semua <span class="material-symbols-outlined text-[14px]">open_in_new</span>
            </a>
        </div>
        <div class="overflow-x-auto px-4 pb-4">
            <table class="w-full text-sm text-left border-separate border-spacing-y-4">
                <thead>
                    <tr class="text-gray-400 text-[10px] uppercase font-bold tracking-[0.2em]">
                        <th class="px-6 py-2">No. Pesanan</th>
                        <th class="px-6 py-2">Tanggal</th>
                        <th class="px-6 py-2">Status</th>
                        <th class="px-6 py-2 text-right">Total</th>
                        <th class="px-6 py-2"></th>
                    </tr>
                </thead>
                <tbody class="space-y-4">
                    @forelse($recentOrders as $order)
                        <tr class="bg-white hover:bg-gray-50/50 transition-all shadow-sm ring-1 ring-gray-100 rounded-2xl group">
                            <td class="px-6 py-5 first:rounded-l-2xl">
                                <span class="text-sm font-bold text-[#111318]">#{{ $order->id }}</span>
                            </td>
                            <td class="px-6 py-5 font-medium text-gray-500 italic text-xs">
                                {{ $order->date }}
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest
                                    {{ $order->status === 'Dikirim' ? 'bg-blue-50 text-blue-600' : 
                                       ($order->status === 'Selesai' ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-600') }}">
                                    <span class="size-1 rounded-full {{ $order->status === 'Dikirim' ? 'bg-blue-600' : ($order->status === 'Selesai' ? 'bg-green-600' : 'bg-gray-600') }}"></span>
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right font-bold text-brandBlue">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5 text-right last:rounded-r-2xl">
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-gray-50 text-gray-400 group-hover:bg-brandBlue group-hover:text-white transition-all text-[10px] font-bold uppercase tracking-widest shadow-sm">
                                    Detail
                                    <span class="material-symbols-outlined text-[14px]">arrow_right_alt</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-24 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="size-20 rounded-full bg-gray-50 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl text-gray-200">shopping_bag</span>
                                    </div>
                                    <p class="text-gray-400 font-serif italic text-lg">Belum ada pesanan.</p>
                                    <a href="{{ route('shop') }}" class="text-xs font-bold text-brandBlue hover:underline uppercase tracking-widest">Mulai Belanja</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
