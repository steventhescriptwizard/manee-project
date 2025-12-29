@extends('layouts.web')

@section('title', 'My Wishlist - Maneé')

@section('content')
<main class="flex-grow w-full max-w-[1200px] mx-auto px-4 md:px-10 py-8 md:py-12 mt-20" x-data="{ wishlist: {{ $products->count() }} }">
    <!-- Page Heading -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10 border-b border-gray-100 pb-8">
        <div>
            <nav class="flex text-xs text-gray-400 mb-2 uppercase tracking-widest font-bold">
                <a href="{{ route('home') }}" class="hover:text-textMain transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span class="text-textMain">Wishlist</span>
            </nav>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-textMain mb-2 tracking-tight">Wishlist</h1>
            <p class="text-gray-500 font-light italic">
                You have <span x-text="wishlist"></span> item<span x-show="wishlist !== 1">s</span> saved for later.
            </p>
        </div>
        
        <template x-if="wishlist > 0">
            <div class="flex gap-4">
                <a href="{{ route('shop') }}" class="flex items-center justify-center gap-2 h-12 px-6 border border-gray-100 bg-white text-textMain text-xs font-bold uppercase tracking-widest rounded-xl transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 active:scale-95">
                    Continue Shopping
                </a>
            </div>
        </template>
    </div>

    <!-- Wishlist Grid -->
    <div x-show="wishlist > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12">
        @foreach($products as $product)
            <div class="relative group" id="wishlist-item-{{ $product->id }}">
                @include('web.partials.product-card', ['product' => $product])
                
                <!-- Explicit Remove Button for Wishlist Page -->
                <button 
                    @click="
                        fetch('{{ route('wishlist.remove') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ product_id: {{ $product->id }} })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if(data.success) {
                                document.getElementById('wishlist-item-{{ $product->id }}').remove();
                                wishlist = data.count;
                                window.dispatchEvent(new CustomEvent('wishlist-updated', { detail: { count: data.count, action: 'removed' } }));
                                showToast('Item removed from wishlist');
                            }
                        })
                    "
                    class="absolute -top-2 -right-2 p-2 bg-white text-gray-400 hover:text-red-500 rounded-full shadow-lg border border-gray-50 z-20 transition-all hover:scale-110 active:scale-90"
                    title="Remove from wishlist"
                >
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        @endforeach

        <!-- Promo/Empty Card Pattern from Reference -->
        <div class="hidden lg:flex flex-col justify-center items-center gap-4 bg-[#F8F9FB] rounded-3xl aspect-[3/4] p-8 text-center border border-dashed border-gray-200 transition-colors">
            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mb-2 shadow-sm border border-gray-50 text-gray-300">
                <span class="material-symbols-outlined text-[32px]">bookmark</span>
            </div>
            <h3 class="text-2xl font-serif font-bold text-textMain tracking-tight">Keep Shopping</h3>
            <p class="text-gray-500 text-sm font-light italic">Discover more styles to add to your collection.</p>
            <a href="{{ route('shop', ['sort' => 'newest']) }}" class="text-brandBlue text-xs font-bold uppercase tracking-widest hover:underline mt-4">
                View New Arrivals
            </a>
        </div>
    </div>

    <!-- Empty State -->
    <div x-show="wishlist === 0" x-cloak class="flex flex-col items-center justify-center py-24 bg-[#F8F9FB] rounded-3xl border border-dashed border-gray-200">
        <div class="inline-flex items-center justify-center h-20 w-20 bg-white rounded-full shadow-sm mb-6 border border-gray-50">
            <span class="material-symbols-outlined text-3xl text-gray-300">bookmark</span>
        </div>
        <h3 class="text-2xl font-serif font-bold text-textMain mb-2 tracking-tight">Your wishlist is empty</h3>
        <p class="text-gray-500 mb-8 max-w-sm mx-auto font-light text-center">Start saving your favorite items now to see them here later.</p>
        <a href="{{ route('shop') }}" class="group flex items-center gap-2 h-14 px-10 bg-textMain text-white rounded-2xl text-sm font-bold uppercase tracking-widest transition-all shadow-xl hover:bg-black hover:shadow-2xl hover:-translate-y-1 active:scale-95">
            Browse Collections
            <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
        </a>
    </div>
</main>
@endsection
