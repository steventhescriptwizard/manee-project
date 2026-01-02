<a href="{{ route('products.show', $product->id) }}" class="w-[160px] md:w-[220px] flex-shrink-0 group/card block transition-all hover:-translate-y-1">
    <div class="bg-white rounded-2xl border-2 border-[#5D4037] flex flex-col h-full shadow-sm hover:shadow-xl transition-all p-[8px]">
        <!-- Image Container -->
        <div class="relative aspect-[3/4] overflow-hidden bg-gray-50 rounded-xl">
            <img src="{{ $product->image_main ? Storage::url($product->image_main) : 'https://via.placeholder.com/400x533' }}" 
                 alt="{{ $product->product_name }}" 
                 class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-700" />
            
            <!-- Badges -->
            <div class="absolute top-2 left-2 flex flex-col gap-1">
                @if($product->is_new_arrival)
                    <span class="bg-white/90 backdrop-blur-sm text-textMain text-[8px] md:text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-widest shadow-sm">New</span>
                @endif
                @if($product->on_sale)
                    <span class="bg-brandRed text-white text-[8px] md:text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-widest shadow-sm">Sale</span>
                @endif
            </div>

            <!-- Bookmark/Wishlist Icon (Togglable) -->
            <div class="absolute top-1 right-1 z-10" 
                 x-data="{ isWishlisted: {{ in_array($product->id, session()->get('wishlist', [])) ? 'true' : 'false' }} }">
                <button 
                    @click.prevent="
                        fetch('{{ route('wishlist.toggle') }}', {
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
                                isWishlisted = data.action === 'added';
                                window.dispatchEvent(new CustomEvent('wishlist-updated', { detail: { count: data.count, action: data.action } }));
                                showToast(data.message);
                            }
                        })
                    "
                    class="flex items-center justify-center p-1 transition-all hover:scale-110 active:scale-90"
                    :class="isWishlisted ? 'text-brandBlue' : 'text-gray-400'"
                >
                    <span class="material-symbols-outlined text-2xl transition-all"
                          :class="{ 'fill-1 font-bold': isWishlisted, 'font-light': !isWishlisted }">
                        bookmark
                    </span>
                </button>
            </div>
        </div>
        
        <!-- Info Container -->
        <div class="p-3 bg-white flex-grow text-left">
            <h3 class="font-sans font-bold text-textMain text-sm md:text-base line-clamp-1 group-hover/card:text-brandBlue transition-colors">{{ $product->product_name }}</h3>
            <p class="font-serif text-xs md:text-sm text-gray-600 mt-0.5">Rp. {{ number_format($product->final_price, 0, ',', '.') }}</p>
        </div>
    </div>
</a>
