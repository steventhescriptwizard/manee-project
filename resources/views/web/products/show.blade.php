@extends('layouts.web')

@section('title', 'Product Detail - Maneé')

@section('content')
<main class="mx-auto max-w-[1280px] px-6 py-6 lg:px-10 mt-20">
    <nav class="mb-8 flex flex-wrap items-center gap-2 text-sm text-gray-500">
        <a class="hover:text-gray-900" href="{{ route('home') }}">Home</a>
        @foreach($product->categories as $category)
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <a class="hover:text-gray-900" href="#">{{ $category->name }}</a>
        @endforeach
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="font-medium text-textMain">{{ $product->product_name }}</span>
    </nav>

@php
    $allImages = collect();
    if($product->image_main) $allImages->push(['id' => 'main', 'path' => Storage::url($product->image_main)]);
    foreach($product->images as $img) {
        $allImages->push(['id' => 'gallery-' . $img->id, 'path' => Storage::url($img->image_path)]);
    }
    foreach($product->variants as $v) {
        if($v->image_path) {
            $allImages->push(['id' => 'variant-' . $v->id, 'path' => Storage::url($v->image_path), 'color' => $v->color]);
        }
    }
    // Unique by path to avoid duplicates
    $allImages = $allImages->unique('path')->values();
@endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 xl:gap-20" 
         x-data="{ 
            allImages: {{ $allImages->toJson() }},
            activeIndex: 0,
            selectedColor: '{{ $colors->first() }}', 
            selectedSize: '{{ $sizes->first() }}',
            variants: {{ $product->variants->map(fn($v) => [
                'id' => $v->id, 
                'color' => $v->color, 
                'size' => $v->size,
                'image' => $v->image_path ? Storage::url($v->image_path) : null
            ])->toJson() }},
            quantity: 1,
            isAdding: false,
            autoSlideInterval: null,
            
            init() {
                this.startAutoSlide();
            },
            
            startAutoSlide() {
                this.stopAutoSlide();
                this.autoSlideInterval = setInterval(() => {
                    this.nextImage();
                }, 5000); // 5 seconds
            },
            
            stopAutoSlide() {
                if (this.autoSlideInterval) {
                    clearInterval(this.autoSlideInterval);
                    this.autoSlideInterval = null;
                }
            },
            
            nextImage() {
                this.activeIndex = (this.activeIndex + 1) % this.allImages.length;
                this.scrollToActive();
            },
            
            scrollToActive() {
                const mainContainer = this.$refs.sliderContainer;
                const thumbContainer = this.$refs.thumbContainer;
                
                if (mainContainer) {
                    mainContainer.scrollTo({
                        left: this.activeIndex * mainContainer.offsetWidth,
                        behavior: 'smooth'
                    });
                }
                
                if (thumbContainer) {
                    const activeThumb = thumbContainer.children[this.activeIndex];
                    if (activeThumb) {
                        thumbContainer.scrollTo({
                            left: activeThumb.offsetLeft - (thumbContainer.offsetWidth / 2) + (activeThumb.offsetWidth / 2),
                            behavior: 'smooth'
                        });
                    }
                }
            },
            
            setActive(index) {
                this.activeIndex = index;
                this.scrollToActive();
                this.startAutoSlide(); // Reset timer
            },

            get currentVariant() {
                return this.variants.find(v => v.color === this.selectedColor && v.size === this.selectedSize);
            },
            get availableSizes() {
                return this.variants
                    .filter(v => v.color === this.selectedColor)
                    .map(v => v.size);
            },
            isSizeAvailable(size) {
                return this.availableSizes.includes(size);
            },
            selectColor(color) {
                this.selectedColor = color;
                if (!this.isSizeAvailable(this.selectedSize)) {
                    this.selectedSize = this.availableSizes[0] || null;
                }
                
                // Find image index for this color
                const colorImageIndex = this.allImages.findIndex(img => img.color === color);
                if (colorImageIndex !== -1) {
                    this.setActive(colorImageIndex);
                }
            },
            async addToCart() {
                this.isAdding = true;
                try {
                    const response = await fetch('{{ route("cart.add") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            product_id: '{{ $product->id }}',
                            variant_id: this.currentVariant ? this.currentVariant.id : null,
                            quantity: this.quantity
                        })
                    });
                    
                    const data = await response.json();
                    if (data.success) {
                        showToast(data.message);
                        window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.cart_count } }));
                    }
                } catch (error) {
                    console.error('Error adding to cart:', error);
                    showToast('Failed to add item to cart');
                } finally {
                    this.isAdding = false;
                }
            }
         }">
        <!-- Image Gallery -->
        <div class="lg:col-span-6" @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()">
            <div class="flex flex-col gap-6">
                <!-- Main Image Slider -->
                <div class="relative aspect-[4/5] w-full max-w-xl mx-auto overflow-hidden rounded-2xl bg-gray-50 border border-gray-100 shadow-sm group">
                    <!-- Slider Container -->
                    <div x-ref="sliderContainer" 
                         class="flex h-full w-full overflow-x-auto snap-x snap-mandatory scrollbar-hide scroll-smooth"
                         @scroll.debounce.100ms="
                            const scrollLeft = $el.scrollLeft;
                            const width = $el.offsetWidth;
                            if (width > 0) activeIndex = Math.round(scrollLeft / width);
                         ">
                        <template x-for="(img, index) in allImages" :key="img.path">
                            <div class="h-full w-full flex-shrink-0 snap-center bg-contain bg-no-repeat bg-center transition-all duration-700" 
                                 :style="'background-image: url(' + img.path + ');'">
                            </div>
                        </template>
                    </div>

                    <!-- Navigation Arrows -->
                    <button @click="setActive((activeIndex - 1 + allImages.length) % allImages.length)" 
                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 backdrop-blur-md p-2.5 rounded-full text-gray-900 shadow-xl opacity-0 group-hover:opacity-100 transition-all transform hover:scale-110 active:scale-95 flex items-center justify-center z-10">
                        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                    </button>
                    <button @click="setActive((activeIndex + 1) % allImages.length)" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 backdrop-blur-md p-2.5 rounded-full text-gray-900 shadow-xl opacity-0 group-hover:opacity-100 transition-all transform hover:scale-110 active:scale-95 flex items-center justify-center z-10">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </button>

                    <!-- Indicators (Dots) -->
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 z-10">
                        <template x-for="(img, index) in allImages" :key="img.path + '-dot'">
                            <button @click="setActive(index)" 
                                    class="h-1 rounded-full transition-all duration-500"
                                    :class="activeIndex === index ? 'w-6 bg-brandBlue' : 'w-1 bg-white/60 hover:bg-white'"></button>
                        </template>
                    </div>

                    <button class="absolute bottom-6 right-6 rounded-full bg-white/90 backdrop-blur-md p-3 text-gray-900 shadow-lg hover:bg-white transition-all transform hover:scale-110 z-10">
                        <span class="material-symbols-outlined text-2xl">zoom_in</span>
                    </button>
                    <!-- Badges -->
                    <div class="absolute top-6 left-6 flex flex-col gap-2 z-10">
                        <span class="bg-brandRed text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">Trending</span>
                    </div>
                </div>

                <!-- Thumbnails at Bottom -->
                <div x-ref="thumbContainer" class="flex gap-3 overflow-x-auto pb-4 scrollbar-hide snap-x mt-4 scroll-smooth">
                    <template x-for="(img, index) in allImages" :key="img.path + '-thumb'">
                        <button @click="setActive(index)" 
                                class="relative aspect-[3/4] w-20 min-w-[80px] overflow-hidden rounded-xl border-2 transition-all snap-start shadow-sm bg-gray-50 shrink-0"
                                :class="activeIndex === index ? 'border-brandBlue ring-2 ring-brandBlue/10' : 'border-transparent hover:border-gray-300 opacity-60 hover:opacity-100'">
                            <img :src="img.path" class="h-full w-full object-contain">
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="lg:col-span-6 flex flex-col pt-2 lg:pt-0">
            <div class="border-b border-gray-100 pb-8">
                <h1 class="font-serif text-4xl lg:text-5xl font-bold leading-tight text-textMain uppercase tracking-tighter">{{ $product->product_name }}</h1>
                <div class="mt-4 flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <p class="text-3xl font-serif font-bold text-brandRed">Rp {{ number_format($product->final_price, 0, ',', '.') }}</p>
                        <div class="flex items-center gap-1 text-amber-400">
                            @for($i = 0; $i < 5; $i++)
                            <span class="material-symbols-outlined text-[18px] fill-current">star</span>
                            @endfor
                        </div>
                    </div>
                    <p class="text-lg font-sans font-medium text-gray-400 italic">Approx. ${{ number_format($priceUsd, 2) }} USD</p>
                </div>
            </div>

            <div class="py-8">
                <p class="text-base leading-relaxed text-gray-500 font-light">
                    {{ $product->description ?: 'No description available for this exquisite piece.' }}
                </p>
            </div>

            <div class="py-8">
                @if($colors->count() > 0)
                <div class="mb-8">
                    <span class="mb-4 block text-sm font-bold text-textMain uppercase tracking-widest">Available Colors</span>
                    <div class="flex gap-4">
                        @foreach($colors as $color)
                        <button @click="selectColor('{{ $color }}')" 
                                class="group relative h-12 w-12 rounded-full border-2 transition-all transform hover:scale-110"
                                :class="selectedColor === '{{ $color }}' ? 'border-brandBlue shadow-lg' : 'border-gray-200'"
                                title="{{ $color }}">
                            <div class="h-full w-full rounded-full border border-white" style="background-color: {{ strtolower($color) }};"></div>
                            <div x-show="selectedColor === '{{ $color }}'" class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-brandBlue uppercase whitespace-nowrap">
                                {{ $color }}
                            </div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($sizes->count() > 0)
                <div class="mb-10">
                    <div class="mb-4 flex items-center justify-between">
                        <span class="text-sm font-bold text-textMain uppercase tracking-widest">Select Size</span>
                        <button class="text-xs font-bold text-gray-400 hover:text-brandRed transition-colors uppercase tracking-widest flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">straighten</span> Size Guide
                        </button>
                    </div>
                    
                    @if($sizes->count() === 1 && strtolower($sizes->first()) === 'all size')
                        <div class="flex">
                            <div class="flex h-14 min-w-[120px] px-6 items-center justify-center rounded-xl border-2 border-brandBlue bg-brandBlue/5 text-textMain shadow-inner text-sm font-bold">
                                {{ $sizes->first() }}
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($sizes as $size)
                            <button @click="isSizeAvailable('{{ $size }}') ? selectedSize = '{{ $size }}' : null"
                                    class="flex h-14 items-center justify-center rounded-xl border-2 text-sm font-bold transition-all relative"
                                    :class="{
                                        'border-brandBlue bg-brandBlue/5 text-textMain shadow-inner': selectedSize === '{{ $size }}',
                                        'border-gray-100 text-gray-400 hover:border-gray-300': selectedSize !== '{{ $size }}' && isSizeAvailable('{{ $size }}'),
                                        'border-gray-50 text-gray-200 cursor-not-allowed opacity-40': !isSizeAvailable('{{ $size }}')
                                    }"
                                    :disabled="!isSizeAvailable('{{ $size }}')">
                                {{ $size }}
                                <template x-if="!isSizeAvailable('{{ $size }}')">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-full h-[1px] bg-gray-300 rotate-45"></div>
                                    </div>
                                </template>
                            </button>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endif

                <div class="flex gap-4 pb-8 border-b border-gray-100" 
                     x-data="{ isWishlisted: {{ in_array($product->id, session()->get('wishlist', [])) ? 'true' : 'false' }} }">
                    <button @click="addToCart" 
                            :disabled="isAdding"
                            class="flex-1 h-14 rounded-lg bg-brandBlue font-sans text-white font-bold tracking-wide transition-transform active:scale-[0.98] hover:bg-brandBlue/90 flex items-center justify-center gap-2 uppercase text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!isAdding" class="flex items-center gap-2">
                             Add to Cart
                        </span>
                        <span x-show="isAdding" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Adding...
                        </span>
                    </button>
                    <button 
                        @click="
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
                        class="h-14 w-14 rounded-lg border border-gray-200 flex items-center justify-center transition-all hover:bg-gray-50 active:scale-95"
                        :class="isWishlisted ? 'text-brandBlue border-brandBlue/20 bg-brandBlue/5' : 'text-gray-400'"
                    >
                        <span class="material-symbols-outlined transition-all"
                              :class="{ 'fill-1 font-bold': isWishlisted }">
                            bookmark
                        </span>
                    </button>
                </div>
            </div>

            <!-- Toast Notification Container -->
            <div id="toast-container" class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[100] flex flex-col gap-2 pointer-events-none"></div>

            <script>
            function showToast(message) {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className = 'bg-textMain text-white px-6 py-3 rounded-full text-sm font-bold shadow-2xl transform translate-y-10 opacity-0 transition-all duration-300 flex items-center gap-2 pointer-events-auto';
                toast.innerHTML = `<span class="material-symbols-outlined text-green-400">check_circle</span> ${message}`;
                
                container.appendChild(toast);
                
                // Trigger animation
                setTimeout(() => {
                    toast.classList.remove('translate-y-10', 'opacity-0');
                }, 10);
                
                // Remove after delay
                setTimeout(() => {
                    toast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
            </script>

            <!-- Accordions -->
            <div class="mt-8 space-y-px bg-white border-t border-gray-100">
                <!-- Description Accordion -->
                <div x-data="{ open: true }" class="border-b border-gray-100">
                    <button @click="open = !open" class="flex w-full items-center justify-between py-4 text-sm font-bold text-textMain uppercase tracking-widest">
                        <span>Description</span>
                        <span class="material-symbols-outlined transition-transform duration-300" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="pb-6 text-sm text-gray-500 font-light leading-relaxed italic">
                        {{ $product->description }}
                    </div>
                </div>

                <!-- Details & Care Accordion -->
                <div x-data="{ open: false }" class="border-b border-gray-100">
                    <button @click="open = !open" class="flex w-full items-center justify-between py-4 text-sm font-bold text-textMain uppercase tracking-widest">
                        <span>Details & Care</span>
                        <span class="material-symbols-outlined transition-transform duration-300" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="pb-6 text-sm text-gray-500 font-light leading-relaxed">
                        @if($product->details_and_care)
                            <ul class="list-disc pl-4 space-y-2 marker:text-gray-400">
                                @foreach(explode(PHP_EOL, $product->details_and_care) as $detail)
                                    @if(trim($detail))
                                        <li class="pl-1">{{ trim($detail) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <ul class="list-disc pl-4 space-y-1">
                                <li>100% Premium Fabric</li>
                                <li>Handle with care for longevity</li>
                                <li>See label for detailed instructions</li>
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Shipping & Returns Accordion -->
                <div x-data="{ open: false }" class="border-b border-gray-100">
                    <button @click="open = !open" class="flex w-full items-center justify-between py-4 text-sm font-bold text-textMain uppercase tracking-widest">
                        <span>Shipping & Returns</span>
                        <span class="material-symbols-outlined transition-transform duration-300" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="pb-6 text-sm text-gray-500 font-light leading-relaxed">
                        <p>Free shipping on all domestic orders over Rp 500.000. Returns accepted within 14 days of delivery. Terms and conditions apply.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews -->
    <div class="mt-20 lg:mt-24 border-t border-[#f0f2f4] pt-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
            <div class="lg:col-span-4">
                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-textMain mb-6">Customer Reviews</h2>
                <div class="mb-10 flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-5xl font-serif font-bold text-textMain">{{ number_format($product->average_rating, 1) }}</span>
                        <div class="flex flex-col">
                            <div class="flex text-amber-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="material-symbols-outlined text-[20px] {{ $i <= $product->average_rating ? 'fill-1' : '' }}">star</span>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 mt-1 italic font-medium">Based on {{ $product->review_count }} reviews</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-8 shadow-sm">
                    <h3 class="font-serif text-xl font-bold text-textMain mb-6">Write a Review</h3>
                    @auth
                    <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Rating</label>
                            <div class="flex gap-1" x-data="{ rating: 5 }">
                                <input type="hidden" name="rating" :value="rating">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button" @click="rating = {{ $i }}" class="text-gray-300 hover:text-amber-400" :class="rating >= {{ $i }} ? 'text-amber-400' : ''">
                                    <span class="material-symbols-outlined text-2xl fill-1" x-show="rating >= {{ $i }}">star</span>
                                    <span class="material-symbols-outlined text-2xl" x-show="rating < {{ $i }}">star</span>
                                </button>
                                @endfor
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Title</label>
                            <input class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-brandBlue focus:ring-brandBlue font-medium" name="title" placeholder="Summary of your review" type="text"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Review</label>
                            <textarea class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-brandBlue focus:ring-brandBlue font-medium" name="content" required placeholder="Tell us about the quality, fit, etc." rows="3"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Photos</label>
                            <input type="file" name="images[]" multiple class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-white file:text-gray-700 hover:file:bg-gray-100 shadow-sm">
                        </div>
                        <button class="w-full rounded-xl bg-brandBlue py-3 text-sm font-bold text-white hover:bg-black transition-all uppercase tracking-widest shadow-lg shadow-brandBlue/20" type="submit">
                            Submit Review
                        </button>
                    </form>
                    @else
                    <div class="text-center py-4">
                        <p class="text-sm text-gray-500 mb-4 italic font-light">Please log in to write a review.</p>
                        <a href="{{ route('login') }}" class="inline-block bg-brandBlue text-white px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest hover:bg-black transition-all">Login Now</a>
                    </div>
                    @endauth
                </div>
            </div>
            <div class="lg:col-span-8 pt-2 lg:pt-14">
                <div class="space-y-10">
                    @forelse($product->reviews->take(3) as $review)
                    <div class="border-b border-gray-100 pb-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 rounded-full bg-brandCream border border-gray-100 flex items-center justify-center text-brandBlue font-bold text-lg shadow-sm">
                                    {{ str($review->user->name)->substr(0, 1)->upper() }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h4 class="text-base font-bold text-textMain">{{ $review->user->name }}</h4>
                                        @if($review->is_verified)
                                        <span class="text-[9px] font-bold uppercase tracking-widest text-green-700 bg-green-50 px-2 py-0.5 rounded-full border border-green-100">Verified</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500 mt-1 italic">
                                        <span>{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                <span class="material-symbols-outlined text-[18px] {{ $i <= $review->rating ? 'fill-1' : '' }}">star</span>
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm leading-relaxed text-gray-600 font-light italic">
                            "{{ $review->content }}"
                        </p>
                        @if($review->images->count() > 0)
                        <div class="flex gap-3 mt-4">
                            @foreach($review->images as $img)
                            <div class="h-20 w-20 rounded-xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50">
                                <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="py-16 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                        <p class="text-gray-500 font-serif italic text-lg opacity-60">No reviews yet for this piece. Be the first to share your thoughts.</p>
                    </div>
                    @endforelse
                </div>
                @if($product->review_count > 3)
                <div class="mt-12 text-center">
                    <a href="{{ route('reviews.index', ['filter' => 'all', 'sort' => 'newest']) }}" class="inline-flex items-center gap-3 text-sm font-bold text-textMain hover:text-brandBlue transition-all uppercase tracking-widest group">
                        <span>View all {{ $product->review_count }} reviews</span>
                        <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">arrow_forward</span>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
                <div class="mt-10 text-center">
                    <button class="inline-flex items-center gap-2 text-sm font-medium text-textMain hover:text-brandBlue transition-colors">
                        <span>View all 128 reviews</span>
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-20 lg:mt-32">
        <h2 class="mb-12 font-serif text-3xl lg:text-4xl font-bold text-textMain uppercase tracking-[0.2em] text-center italic">You May Also Like</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-10">
            @foreach($relatedProducts as $rel)
            <a href="{{ route('products.show', $rel->id) }}" class="group flex flex-col gap-4">
                <div class="relative w-full overflow-hidden rounded-xl aspect-[3/4] border border-gray-100 bg-gray-50 shadow-sm transition-all group-hover:shadow-md">
                    <img src="{{ $rel->image_main ? asset('storage/' . $rel->image_main) : 'https://via.placeholder.com/300x400' }}" alt="{{ $rel->product_name }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" />
                    <button class="absolute bottom-4 right-4 flex h-10 w-10 translate-y-2 items-center justify-center rounded-full bg-white text-textMain opacity-0 shadow-lg transition-all group-hover:translate-y-0 group-hover:opacity-100 hover:bg-brandBlue hover:text-white">
                        <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                    </button>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-textMain uppercase tracking-wider group-hover:text-brandBlue transition-colors line-clamp-1">{{ $rel->product_name }}</h3>
                    <p class="text-xs font-serif font-bold text-brandRed mt-1 italic">Rp {{ number_format($rel->final_price, 0, ',', '.') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</main>
@endsection
