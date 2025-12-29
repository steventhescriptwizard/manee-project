@extends('layouts.admin')

@section('title', 'Profil Pelanggan - ' . $user->name)

@section('content')
<div class="max-w-[1200px] mx-auto flex flex-col gap-6">
    {{-- Breadcrumbs --}}
    <div class="flex flex-wrap gap-2 items-center text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-blue-600 transition-colors font-medium">Home</a>
        <span class="text-slate-400 font-medium">/</span>
        <a href="{{ route('admin.customers.index') }}" class="text-slate-500 hover:text-blue-600 transition-colors font-medium">Pelanggan</a>
        <span class="text-slate-400 font-medium">/</span>
        <span class="text-slate-900 dark:text-white font-semibold">{{ $user->name }}</span>
    </div>

    {{-- Profile Header Card --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-800 overflow-hidden">
        {{-- Top Gradient Accent --}}
        <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700 w-full relative">
            <div class="absolute -bottom-12 left-8 md:left-10">
                <div class="size-24 md:size-32 rounded-3xl border-4 border-white dark:border-gray-900 bg-white dark:bg-gray-800 shadow-xl flex items-center justify-center overflow-hidden">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 font-black text-3xl">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="pt-16 px-8 pb-8 md:px-10 md:flex md:justify-between md:items-start gap-6">
            <div class="flex-1">
                <h1 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white flex items-center gap-3">
                    {{ $user->name }}
                    <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-widest dark:bg-green-900/30 dark:text-green-400 border border-green-100 dark:border-green-800">AKTIF</span>
                </h1>
                <div class="mt-4 flex flex-col gap-2 text-slate-500 dark:text-slate-400 text-sm md:text-base">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] text-blue-600">mail</span>
                        <span class="font-medium">{{ $user->email }}</span>
                    </div>
                    @if($user->customer && $user->customer->phone)
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px] text-blue-600">call</span>
                            <span class="font-medium">{{ $user->customer->phone }}</span>
                        </div>
                    @endif
                    <div class="flex items-center gap-3 mt-1 underline decoration-blue-200 underline-offset-4 decoration-2">
                        <span class="material-symbols-outlined text-[20px] text-slate-400">calendar_month</span>
                        <span class="text-xs font-bold uppercase tracking-tight">Member sejak: {{ $user->created_at->translatedFormat('M Y') }}</span>
                    </div>
                </div>

                {{-- Related User Badge --}}
                <div class="mt-4 flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-gray-800 rounded-xl w-fit">
                    <span class="material-symbols-outlined text-[16px] text-slate-400">link</span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Linked User ID: #{{ $user->id }}</span>
                </div>
            </div>
            
            {{-- Actions & Stats --}}
            <div class="mt-8 md:mt-0 flex flex-col items-start md:items-end gap-6">
                {{-- Stats Cards Row --}}
                <div class="flex flex-wrap gap-4">
                    <div class="px-6 py-4 rounded-2xl bg-slate-50 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-700 text-center min-w-[140px] shadow-sm">
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest mb-1">Total Belanja</p>
                        <p class="text-xl font-black text-blue-600">Rp {{ number_format($totalSpend, 0, ',', '.') }}</p>
                    </div>
                    <div class="px-6 py-4 rounded-2xl bg-slate-50 dark:bg-gray-800/50 border border-slate-100 dark:border-gray-700 text-center min-w-[140px] shadow-sm">
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest mb-1">Total Pesanan</p>
                        <p class="text-xl font-black text-slate-900 dark:text-white">{{ $totalOrders }}</p>
                    </div>
                </div>
                
                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('admin.customers.edit', $user->id) }}" class="flex items-center gap-2 px-6 h-11 bg-slate-900 dark:bg-blue-600 hover:opacity-90 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-slate-200 dark:shadow-none">
                        <span class="material-symbols-outlined text-[20px]">edit</span>
                        <span>Edit Profil</span>
                    </a>
                    <button class="flex items-center gap-2 px-6 h-11 bg-white dark:bg-gray-800 hover:bg-slate-50 dark:hover:bg-gray-750 text-slate-900 dark:text-white border border-slate-200 dark:border-gray-700 text-sm font-bold rounded-xl transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                        <span>Reset Sandi</span>
                    </button>
                    <form action="{{ route('admin.customers.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn flex items-center justify-center size-11 bg-white dark:bg-gray-800 hover:bg-red-50 hover:border-red-200 hover:text-red-600 dark:hover:bg-red-900/20 text-slate-400 border border-slate-200 dark:border-gray-700 rounded-xl transition-all group" title="Blokir Akun">
                            <span class="material-symbols-outlined text-[22px]">block</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column --}}
        <div class="lg:col-span-1 flex flex-col gap-6">
            {{-- Personal Info Card --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-800 p-6 flex flex-col gap-8">
                <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="size-2 bg-blue-600 rounded-full"></span>
                    Informasi Pribadi
                </h3>
                <div class="grid grid-cols-1 gap-6">
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Nama Lengkap</span>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->name }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Tanggal Lahir</span>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->customer?->date_of_birth ?? 'Belum diisi' }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Jenis Kelamin</span>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ ($user->customer?->gender === 'female') ? 'Wanita' : (($user->customer?->gender === 'male') ? 'Pria' : 'Tidak ditentukan') }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Grup Pelanggan</span>
                        <span class="inline-flex w-fit px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-black rounded-lg uppercase tracking-wider border border-blue-100 dark:border-blue-800">
                            {{ strtoupper($user->customer?->tier ?? 'Regular') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Addresses Card --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-800 p-6">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="size-2 bg-blue-600 rounded-full"></span>
                        Alamat Tersimpan
                    </h3>
                    <span class="px-2 py-1 bg-slate-100 dark:bg-gray-800 rounded-lg text-[10px] font-bold text-slate-500">{{ $user->customer?->addresses->count() ?? 0 }} Alamat</span>
                </div>
                <div class="flex flex-col gap-5">
                    @forelse($user->customer?->addresses ?? [] as $addr)
                        <div class="p-4 rounded-xl border {{ $addr->is_primary ? 'border-blue-200 dark:border-blue-800 bg-blue-50/30 dark:bg-blue-900/10' : 'border-slate-100 dark:border-gray-800 hover:bg-slate-50 dark:hover:bg-gray-850' }} transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[18px] text-blue-600">{{ $addr->label === 'Rumah' ? 'home' : 'work' }}</span>
                                    <span class="text-sm font-black text-slate-900 dark:text-white">{{ $addr->label }}</span>
                                </div>
                                @if($addr->is_primary)
                                    <span class="text-[9px] font-black text-blue-600 uppercase tracking-tighter">Utama</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                                {{ $addr->address_line }}, {{ $addr->city }}, {{ $addr->province }}, {{ $addr->postal_code }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-sm text-slate-400 italic">Belum ada alamat tersimpan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Admin Notes --}}
            <div class="bg-slate-900 rounded-2xl p-6 shadow-xl">
                <h3 class="text-base font-black text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-400 text-[20px]">edit_note</span>
                    Catatan Admin
                </h3>
                <textarea 
                    class="w-full rounded-xl bg-gray-800 border-none text-sm text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-600 p-4 min-h-[120px] shadow-inner font-medium" 
                    placeholder="Tulis catatan internal untuk pelanggan ini..."
                ></textarea>
                <div class="flex justify-end mt-4">
                    <button class="px-5 py-2 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">
                        Simpan Catatan
                    </button>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="lg:col-span-2 flex flex-col gap-6">
            {{-- Recent Orders --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-800 overflow-hidden flex flex-col min-h-[500px]">
                <div class="p-6 border-b border-slate-100 dark:border-gray-800 flex justify-between items-center bg-slate-50/50 dark:bg-gray-800/30">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">Riwayat Pesanan</h3>
                    <span class="material-symbols-outlined text-slate-400">shopping_bag</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50/30 dark:bg-gray-800/50 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-4">Nomor Pesanan</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Total</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-gray-800">
                            @forelse($user->orders as $order)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-800/20 transition-all group">
                                    <td class="px-6 py-4">
                                        <div class="font-black text-blue-600 group-hover:underline underline-offset-4 decoration-2">#{{ $order->order_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 font-bold">{{ $order->created_at->translatedFormat('d M Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $orderStatusColors = [
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'processing' => 'bg-blue-100 text-blue-700',
                                                'shipped' => 'bg-indigo-100 text-indigo-700',
                                                'completed' => 'bg-green-100 text-green-700',
                                                'cancelled' => 'bg-red-100 text-red-700',
                                            ];
                                            $orderColor = $orderStatusColors[$order->status] ?? 'bg-slate-100 text-slate-700';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-tight {{ $orderColor }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-slate-900 dark:text-white font-black">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex size-9 items-center justify-center rounded-xl bg-slate-50 dark:bg-gray-800 text-slate-400 hover:text-blue-600 transition-all border border-slate-100 dark:border-gray-700 shadow-sm">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2 opacity-30">
                                            <span class="material-symbols-outlined text-4xl">inventory_2</span>
                                            <p class="text-sm font-bold">Belum ada transaksi.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Activity Log Placeholder --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-slate-200 dark:border-gray-800 p-8">
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-8 flex items-center gap-2">
                    <span class="size-2 bg-blue-600 rounded-full"></span>
                    Aktivitas Terbaru
                </h3>
                <div class="relative pl-6 border-l-2 border-slate-100 dark:border-gray-800 space-y-10">
                    {{-- Activities --}}
                    <div class="relative">
                        <div class="absolute -left-[33px] top-1.5 size-3.5 rounded-full bg-blue-600 ring-4 ring-white dark:ring-gray-900 shadow-sm shadow-blue-200"></div>
                        <p class="text-sm font-black text-slate-900 dark:text-white">Login akun berhasil</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ now()->translatedFormat('d M Y, H:i') }} WIB</p>
                    </div>
                    @if($user->orders->count() > 0)
                        <div class="relative">
                            <div class="absolute -left-[33px] top-1.5 size-3.5 rounded-full bg-slate-200 dark:bg-gray-700 ring-4 ring-white dark:ring-gray-900"></div>
                            <p class="text-sm font-black text-slate-900 dark:text-white">Membuat pesanan baru <span class="text-blue-600">#{{ $user->orders->first()->order_number }}</span></p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $user->orders->first()->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                        </div>
                    @endif
                    <div class="relative">
                        <div class="absolute -left-[33px] top-1.5 size-3.5 rounded-full bg-slate-200 dark:bg-gray-700 ring-4 ring-white dark:ring-gray-900"></div>
                        <p class="text-sm font-black text-slate-900 dark:text-white">Pendaftaran akun berhasil</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $user->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
