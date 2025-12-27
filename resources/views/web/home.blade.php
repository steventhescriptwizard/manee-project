@extends('layouts.web')

@section('title', 'Maneé Fashion Store - Elegant & Timeless')

@section('content')
<div class="w-full">
    <!-- Hero Section -->
    <section class="relative h-screen w-full overflow-hidden" 
             x-data="{ 
                activeSlide: 0, 
                slides: [
                    'https://lh3.googleusercontent.com/aida-public/AB6AXuCbsxAlEW3MhJQg1YK49Nau0qc_Nn0EOHwwnyuDNJeNpWbulFCuGIGT-XPkaHJueFIpL70tMgiEJtseI3IOqa6rrUUdw7cpQtFI0RzfWzWPApM6IQWWgEZ7h6z8eFxmCoh_kmmJMLhFWUDc4h8BXML1zj__No8A0FQGp0o1Wf9DV-uEAUTsaoDrLQLuEdRE5lm5635Hl0Iz_gOTPr2kcVEmSXAY6sCkj7qH3D1pmfP8hCVOdRVcH-H1bY8zkfos0wM_KtxsH60lAEs',
                    '{{ asset('images/hero.png') }}',
                    '{{ asset('images/hero-1.png') }}'
                ],
                next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
                init() { setInterval(() => this.next(), 5000) }
             }">
        
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0">
                <img :src="slide" alt="Fashion model" class="w-full h-full object-cover object-top" />
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/20 to-transparent"></div>
            </div>
        </template>

        <!-- Decorative blur (Persistent across slides) -->
        <div class="absolute top-0 right-0 w-[80vh] h-[80vh] rounded-full bg-[#791F1F] mix-blend-multiply opacity-80 blur-3xl transform translate-x-1/4 -translate-y-1/4 pointer-events-none hidden lg:block z-10"></div>
        
        <div class="relative container mx-auto px-6 h-full flex flex-col justify-center text-white z-20">
            <div class="max-w-xl mt-16 md:mt-0 md:ml-12">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-serif italic font-light leading-tight mb-6">
                    Headline Here and<br/>Can Go Over Two Lines
                </h1>
                <p class="text-lg md:text-xl font-sans font-light mb-10 max-w-md opacity-90">
                    Subheadline goes here and can<br/>go over two lines
                </p>
                <a href="#" class="inline-block border border-white px-8 py-3 text-sm tracking-widest uppercase hover:bg-white hover:text-black transition-colors duration-300">
                    CTA Here
                </a>
            </div>
        </div>

        <!-- Hero Controls -->
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition-colors p-2 z-30">
            <span class="material-symbols-outlined text-4xl">chevron_left</span>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition-colors p-2 z-30">
            <span class="material-symbols-outlined text-4xl">chevron_right</span>
        </button>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex gap-3 z-30">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="w-3 h-3 rounded-full border border-white transition-all"
                        :class="activeSlide === index ? 'bg-white w-8' : 'hover:bg-white/50'"></button>
            </template>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-20 bg-brandCream">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $catImages = [
                        asset('images/knitwear.png'),
                        asset('images/tops.png'),
                        asset('images/bottoms.png'),
                    ];
                @endphp
                @foreach($categories as $index => $cat)
                <a href="#" class="group relative h-[250px] overflow-hidden rounded-lg block">
                    <img src="{{ $cat->image_path ?? ($catImages[$index] ?? asset('images/knitwear.png')) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-80"></div>
                    <div class="absolute bottom-10 left-0 w-full text-center">
                        <span class="text-white text-2xl font-sans font-light border-b border-white/50 pb-1">{{ $cat->name }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Product Slider Section -->
    <section class="py-16 bg-[#FDFBF7]">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10">
                <h2 class="text-3xl md:text-4xl font-sans font-medium text-textMain">Shop Categories</h2>
                <div class="flex gap-8 mt-6 md:mt-0">
                    <button class="text-textMain font-sans text-lg border-b border-current pb-1">Best Sellers</button>
                    <button class="text-gray-500 font-sans text-lg hover:text-textMain border-b border-transparent hover:border-current pb-1 transition-all">New Arrivals</button>
                    <button class="text-gray-500 font-sans text-lg hover:text-textMain border-b border-transparent hover:border-current pb-1 transition-all">Sale</button>
                </div>
            </div>
            
            <div class="relative group" x-data>
                <div class="flex gap-6 overflow-x-auto hide-scrollbar pb-8 scroll-smooth" id="product-slider">
                    @foreach($products as $prod)
                    <a href="{{ route('products.show', $prod->id) }}" class="min-w-[160px] md:min-w-[200px] bg-white rounded-lg overflow-hidden border border-gray-100 group/card block">
                        <div class="relative aspect-[3/4] overflow-hidden bg-gray-100 border-2 border-[#791F1F]/20 rounded-lg group-hover/card:border-[#791F1F]/40 transition-colors">
                            <img src="{{ $prod->image_main ? asset('storage/' . $prod->image_main) : 'https://via.placeholder.com/300x400' }}" alt="{{ $prod->product_name }}" class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500" />
                            <div class="absolute top-3 right-3 flex flex-col gap-2">
                                <button class="text-gray-800 hover:text-brandRed transition-colors bg-white/80 p-1.5 rounded-full shadow-sm">
                                    <span class="material-icons-outlined text-[20px]">bookmark_border</span>
                                </button>
                            </div>
                        </div>
                        <div class="p-3 md:p-4">
                            <h3 class="font-sans font-medium text-textMain mb-1 line-clamp-1">{{ $prod->product_name }}</h3>
                            <p class="font-sans text-sm text-gray-500 font-bold text-brandRed">Rp {{ number_format($prod->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <!-- Scroll Buttons -->
                <button 
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/2 bg-white shadow-lg rounded-full p-3 hidden md:block hover:bg-gray-50 transition-colors z-10"
                    @click="document.getElementById('product-slider').scrollBy({left: -220, behavior: 'smooth'})"
                >
                    <span class="material-icons-outlined text-gray-800">chevron_left</span>
                </button>
                <button 
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/2 bg-white shadow-lg rounded-full p-3 hidden md:block hover:bg-gray-50 transition-colors z-10"
                    @click="document.getElementById('product-slider').scrollBy({left: 220, behavior: 'smooth'})"
                >
                    <span class="material-icons-outlined text-gray-800">chevron_right</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Promo Section -->
    <section class="relative h-[500px] w-full bg-gray-900 overflow-hidden">
        <img 
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCHQpNjp7DhmlQfL0YlVDdpRkuAFvfN2JprEFlYTJydhYdz_jcR3gcw03Wfr4i3l5PabQeZ8fEV0jVUdrbXOTDN48vChJyl5FdArV8O9wQ6oY0UCNDHV-IziY1flPZaYscK4KQEU6bO5CgcvA7S_Wj4FsCq4yQ9wyxYFTkqwRu09gYUdG5W1tF97hm3-asFGKjExVxPTqH2pcfS0IadWFBrkkHHDTfG2SsJ4jswIogKBQAQ_aAnWkZxbLdu2AiJZmO1dmrdYE371nQ" 
            alt="Leather bag detail" 
            class="w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="container mx-auto px-6">
                <div class="max-w-lg text-white md:ml-12">
                    <h2 class="text-5xl font-serif italic font-light mb-4">Receive 10% Off</h2>
                    <p class="text-lg font-sans font-light mb-8 text-white/90">
                        Enjoy 10% off your first purchase,<br/>
                        and other promotional offers<br/>
                        by becoming our members.
                    </p>
                    <button class="inline-block border border-white px-8 py-3 text-sm tracking-widest uppercase hover:bg-white hover:text-black transition-colors duration-300 rounded">
                        Register Now
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Utilities */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
@endsection
