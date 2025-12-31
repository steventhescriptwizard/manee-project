@extends('web.customer.layouts.app')

@section('customer_content')
<div class="space-y-6 animate-fade-in" x-data="{ 
    filter: '{{ $filter }}',
    updateFilter(newFilter) {
        window.location.href = '{{ route('customer.notifications.index') }}?filter=' + newFilter;
    }
}">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-6 border-b border-gray-100">
        <div class="flex flex-col gap-2">
            <h1 class="text-3xl md:text-4xl font-serif font-bold text-[#111318]">Notifikasi Anda</h1>
            <p class="text-gray-500 font-light">
                @if(Auth::user()->unreadNotifications->count() > 0)
                    Anda memiliki {{ Auth::user()->unreadNotifications->count() }} notifikasi baru.
                @else
                    Pantau pesanan dan promo terbaru khusus untuk Anda.
                @endif
            </p>
        </div>
        <div class="flex gap-3">
            <form action="{{ route('customer.notifications.read', 'all') }}" method="POST">
                @csrf
                <button 
                    type="submit"
                    class="group flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg hover:border-brandBlue/50 hover:bg-brandBlue/5 transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ Auth::user()->unreadNotifications->count() === 0 ? 'disabled' : '' }}
                >
                    <span class="material-symbols-outlined text-gray-400 group-hover:text-brandBlue text-[20px]">done_all</span>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-brandBlue">Tandai semua dibaca</span>
                </button>
            </form>

            <form action="{{ route('customer.notifications.destroy', 'all') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')">
                @csrf
                @method('DELETE')
                <button 
                    type="submit"
                    class="group flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg hover:border-brandRed/50 hover:bg-brandRed/5 transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ $notifications->count() === 0 ? 'disabled' : '' }}
                >
                    <span class="material-symbols-outlined text-gray-400 group-hover:text-brandRed text-[20px]">delete_sweep</span>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-brandRed">Hapus semua</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex items-center gap-8 border-b border-gray-100 mb-6 overflow-x-auto no-scrollbar">
        <button 
            @click="updateFilter('ALL')"
            class="pb-3 border-b-2 text-sm font-medium whitespace-nowrap px-1 transition-colors {{ $filter === 'ALL' ? 'border-[#111318] text-[#111318]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
        >
            Semua
        </button>
        <button 
            @click="updateFilter('ORDER')"
            class="pb-3 border-b-2 text-sm font-medium whitespace-nowrap px-1 transition-colors {{ $filter === 'ORDER' ? 'border-[#111318] text-[#111318]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
        >
            Pesanan
        </button>
        <button 
            @click="updateFilter('FINANCE')"
            class="pb-3 border-b-2 text-sm font-medium whitespace-nowrap px-1 transition-colors {{ $filter === 'FINANCE' ? 'border-[#111318] text-[#111318]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
        >
            Keuangan
        </button>
        <button 
            @click="updateFilter('PROMO')"
            class="pb-3 border-b-2 text-sm font-medium whitespace-nowrap px-1 transition-colors {{ $filter === 'PROMO' ? 'border-[#111318] text-[#111318]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
        >
            Promo & Info
        </button>
    </div>

    <!-- Notification List -->
    <div class="space-y-3">
        @forelse($notifications as $notification)
            <div class="flex gap-4 p-4 rounded-xl border transition-all hover:bg-gray-50 {{ $notification->read_at ? 'bg-white border-gray-100' : 'bg-brandBlue/5 border-brandBlue/20' }}">
                <!-- Icon -->
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center 
                        {{ Str::contains($notification->type, 'Order') ? 'bg-blue-100 text-blue-600' : 
                           (Str::contains($notification->type, 'Payment') ? 'bg-green-100 text-green-600' : 
                           (Str::contains($notification->type, 'Promo') ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-600')) }}">
                        <span class="material-symbols-outlined text-[20px]">
                            {{ Str::contains($notification->type, 'Order') ? 'local_shipping' : 
                               (Str::contains($notification->type, 'Payment') ? 'payments' : 
                               (Str::contains($notification->type, 'Promo') ? 'campaign' : 'notifications')) }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-grow min-w-0">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <div>
                            <h4 class="text-sm font-bold text-[#111318] {{ !$notification->read_at ? 'text-brandBlue' : '' }}">
                                {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
                            </h4>
                            <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            @if(!$notification->read_at)
                                <form action="{{ route('customer.notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-brandBlue hover:bg-brandBlue/10 rounded-full" title="Tandai dibaca">
                                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('customer.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-brandRed hover:bg-brandRed/10 rounded-full" title="Hapus">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $notification->data['message'] ?? 'Tidak ada pesan.' }}
                    </p>

                    @if(isset($notification->data['action_url']))
                        <a href="{{ $notification->data['action_url'] }}" class="inline-flex items-center gap-1 mt-3 text-xs font-bold uppercase tracking-wider text-brandBlue hover:text-brandBlue/80">
                            {{ $notification->data['action_text'] ?? 'Lihat Detail' }}
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-xl border border-dashed border-gray-200">
                <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">notifications_off</span>
                <p class="text-gray-500 font-medium">Tidak ada notifikasi ditemukan</p>
                <p class="text-xs text-gray-400 mt-1">Belum ada aktivitas terbaru untuk ditampilkan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $notifications->appends(['filter' => $filter])->links() }}
    </div>
</div>

<style>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
@endsection
