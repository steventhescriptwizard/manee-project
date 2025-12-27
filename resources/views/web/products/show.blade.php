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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 xl:gap-16">
        <!-- Image Gallery -->
        <div class="lg:col-span-7" x-data="{ activeImage: '{{ $product->image_main ? Storage::url($product->image_main) : 'https://via.placeholder.com/600x800' }}' }">
            <div class="flex flex-col gap-6">
                <!-- Main Image -->
                <div class="relative aspect-[4/5] w-full overflow-hidden rounded-2xl bg-gray-50 border border-gray-100 shadow-sm">
                    <div class="h-full w-full bg-cover bg-center transition-all duration-700" :style="'background-image: url(' + activeImage + ');'"></div>
                    <button class="absolute bottom-6 right-6 rounded-full bg-white/90 backdrop-blur-md p-3 text-gray-900 shadow-lg hover:bg-white transition-all transform hover:scale-110">
                        <span class="material-symbols-outlined text-2xl">zoom_in</span>
                    </button>
                    <!-- Badges -->
                    <div class="absolute top-6 left-6 flex flex-col gap-2">
                        <span class="bg-brandRed text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">Trending</span>
                    </div>
                </div>

                <!-- Thumbnails at Bottom -->
                <div class="flex gap-3 overflow-x-auto pb-4 scrollbar-hide snap-x mt-4">
                    <!-- Main Image Thumbnail -->
                    @if($product->image_main)
                    <button @click="activeImage = '{{ Storage::url($product->image_main) }}'" 
                            class="relative aspect-[3/4] w-20 min-w-[80px] overflow-hidden rounded-xl border-2 transition-all snap-start shadow-sm"
                            :class="activeImage === '{{ Storage::url($product->image_main) }}' ? 'border-brandBlue ring-2 ring-brandBlue/10' : 'border-transparent hover:border-gray-300 opacity-60 hover:opacity-100'">
                        <img src="{{ Storage::url($product->image_main) }}" class="h-full w-full object-cover">
                    </button>
                    @endif

                    <!-- Gallery Images -->
                    @foreach($product->images as $image)
                    <button @click="activeImage = '{{ Storage::url($image->image_path) }}'" 
                            class="relative aspect-[3/4] w-20 min-w-[80px] overflow-hidden rounded-xl border-2 transition-all snap-start shadow-sm"
                            :class="activeImage === '{{ Storage::url($image->image_path) }}' ? 'border-brandBlue ring-2 ring-brandBlue/10' : 'border-transparent hover:border-gray-300 opacity-60 hover:opacity-100'">
                        <img src="{{ Storage::url($image->image_path) }}" class="h-full w-full object-cover">
                    </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="lg:col-span-5 flex flex-col pt-2 lg:pt-0">
            <div class="border-b border-gray-100 pb-8">
                <h1 class="font-serif text-4xl lg:text-5xl font-bold leading-tight text-textMain uppercase tracking-tighter">{{ $product->product_name }}</h1>
                <div class="mt-4 flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <p class="text-3xl font-serif font-bold text-brandRed">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
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

            <div x-data="{ 
                selectedColor: '{{ $colors->first() }}', 
                selectedSize: '{{ $sizes->first() }}',
                variants: {{ $product->variants->map(fn($v) => ['color' => $v->color, 'size' => $v->size])->toJson() }},
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
                }
            }">
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
                </div>
                @endif

                <div class="flex gap-4 pb-8 border-b border-gray-100">
                    <button class="flex-1 h-14 rounded-lg bg-brandBlue font-sans text-white font-bold tracking-wide transition-transform active:scale-[0.98] hover:bg-brandBlue/90 flex items-center justify-center gap-2 uppercase text-sm">
                        Add to Cart
                    </button>
                    <button class="h-14 w-14 rounded-lg border border-gray-200 flex items-center justify-center text-textMain hover:bg-gray-50 transition-colors">
                        <span class="material-symbols-outlined">favorite</span>
                    </button>
                </div>
            </div>

            <!-- Accordions -->
            <div class="mt-6">
                <div x-data="{ open: false }" class="border-b border-gray-100">
                    <button @click="open = !open" class="flex w-full items-center justify-between py-4 text-sm font-medium text-textMain">
                        <span>Details & Care</span>
                        <span class="material-symbols-outlined transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="open" class="pb-4 text-sm text-gray-600">
                        <ul class="list-disc pl-4 space-y-1">
                            <li>100% Premium Linen</li>
                            <li>Machine wash cold, gentle cycle</li>
                            <li>Do not bleach</li>
                            <li>Hang to dry</li>
                        </ul>
                    </div>
                </div>
                <div x-data="{ open: false }" class="border-b border-gray-100">
                    <button @click="open = !open" class="flex w-full items-center justify-between py-4 text-sm font-medium text-textMain">
                        <span>Shipping & Returns</span>
                        <span class="material-symbols-outlined transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="open" class="pb-4 text-sm text-gray-600">
                        <p>Free shipping on all domestic orders over Rp 500.000. Returns accepted within 14 days of delivery.</p>
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
                        <span class="text-5xl font-serif font-bold text-textMain">4.8</span>
                        <div class="flex flex-col">
                            <div class="flex text-amber-400 text-sm">
                                <span class="material-symbols-outlined text-[20px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[20px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[20px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[20px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[20px] fill-current opacity-50">star_half</span>
                            </div>
                            <span class="text-xs text-gray-500 mt-1">Based on 128 reviews</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border border-gray-100 bg-gray-50 p-6">
                    <h3 class="font-serif text-lg font-bold text-textMain mb-4">Write a Review</h3>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Rating</label>
                            <div class="flex gap-1 text-gray-300">
                                @for($i = 0; $i < 5; $i++)
                                <button class="hover:text-amber-400" type="button"><span class="material-symbols-outlined fill-current">star</span></button>
                                @endfor
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1" for="name">Name</label>
                            <input class="w-full rounded border-gray-200 bg-white px-3 py-2 text-sm focus:border-brandBlue focus:ring-brandBlue" id="name" placeholder="Your name" type="text"/>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1" for="review">Review</label>
                            <textarea class="w-full rounded border-gray-200 bg-white px-3 py-2 text-sm focus:border-brandBlue focus:ring-brandBlue" id="review" placeholder="How was the product?" rows="3"></textarea>
                        </div>
                        <button class="w-full rounded bg-brandBlue px-4 py-2.5 text-sm font-bold text-white hover:bg-brandBlue/90 transition-colors uppercase" type="button">
                            Submit Review
                        </button>
                    </form>
                </div>
            </div>
            <div class="lg:col-span-8 pt-2 lg:pt-14">
                <div class="space-y-8">
                    @foreach(['Sarah Jenkins', 'Michelle A.', 'Dian Larasati'] as $reviewer)
                    <div class="border-b border-gray-100 pb-8">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm">
                                    {{ substr($reviewer, 0, 1) }}{{ strpos($reviewer, ' ') !== false ? substr($reviewer, strpos($reviewer, ' ') + 1, 1) : 'A' }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-textMain">{{ $reviewer }}</h4>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <span>2 days ago</span>
                                        <span>•</span>
                                        <span>Ordered Size M</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex text-amber-400">
                                @for($i = 0; $i < 5; $i++)
                                <span class="material-symbols-outlined text-[16px] fill-current">star</span>
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm leading-relaxed text-gray-600 mt-3">
                            Absolutely love this shirt! The linen quality is fantastic, very soft and breathable. It fits perfectly, slightly oversized as described. The sage green color is exactly like the photos. Highly recommend for anyone looking for a versatile summer piece.
                        </p>
                    </div>
                    @endforeach
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
                    <p class="text-xs font-serif font-bold text-brandRed mt-1 italic">Rp {{ number_format($rel->price, 0, ',', '.') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</main>
@endsection
