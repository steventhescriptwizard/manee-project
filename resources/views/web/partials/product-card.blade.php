<a href="{{ route('products.show', $prod->id) }}" class="w-[160px] md:w-[220px] flex-shrink-0 group/card block transition-all hover:-translate-y-1">
    <div class="bg-white rounded-2xl overflow-hidden border-2 border-[#5D4037] flex flex-col h-full shadow-sm hover:shadow-xl transition-all">
        <!-- Image Container -->
        <div class="relative aspect-[3/4] overflow-hidden bg-gray-50">
            <img src="{{ $prod->image_main ? Storage::url($prod->image_main) : 'https://via.placeholder.com/400x533' }}" 
                 alt="{{ $prod->product_name }}" 
                 class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-700" />
            
            <!-- Badges -->
            <div class="absolute top-2 left-2 flex flex-col gap-1">
                @if($prod->is_new_arrival)
                    <span class="bg-white/90 backdrop-blur-sm text-textMain text-[8px] md:text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-widest shadow-sm">New</span>
                @endif
                @if($prod->on_sale)
                    <span class="bg-brandRed text-white text-[8px] md:text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-widest shadow-sm">Sale</span>
                @endif
            </div>

            <!-- Bookmark/Wishlist Icon (Matches Reference) -->
            <div class="absolute top-0 right-3">
                <span class="material-symbols-outlined text-[#5D4037] text-2xl [font-variation-settings:'FILL'_1]">bookmark</span>
            </div>
        </div>
        
        <!-- Info Container (Inside Border) -->
        <div class="p-3 bg-[#FCFAF7] border-t border-[#5D4037]/10 flex-grow text-left">
            <h3 class="font-sans font-bold text-textMain text-sm md:text-base line-clamp-1 group-hover/card:text-brandBlue transition-colors">{{ $prod->product_name }}</h3>
            <p class="font-serif text-xs md:text-sm text-gray-600 mt-0.5">Rp. {{ number_format($prod->price, 0, ',', '.') }}</p>
        </div>
    </div>
</a>
