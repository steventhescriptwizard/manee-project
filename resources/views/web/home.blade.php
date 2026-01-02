@extends('layouts.web')

@section('title', 'Maneé Fashion Store - Elegant & Timeless')

@section('content')
<div class="w-full">
    <!-- Hero Section -->
    <section class="relative h-screen w-full overflow-hidden" 
             x-data="{ 
                activeSlide: 0, 
                slides: [
                    '{{ asset('images/hero.png') }}',
                    '{{ asset('images/hero-1.png') }}',
                    'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop'
                ],
                next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
                init() { 
                    setInterval(() => this.next(), 5000);
                }
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
            <div class="max-w-xl mt-16 md:mt-0 md:ml-12 min-h-[160px]"> <!-- Added min-height to prevent layout shift -->
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-5xl mx-auto">
                @php
                    $catImages = [
                        asset('images/knitwear.png'),
                        asset('images/tops.png'),
                        asset('images/bottoms.png'),
                    ];
                @endphp
                @foreach($categories as $index => $cat)
                <a href="{{ route('categories.show', $cat->slug) }}" class="group relative block">
                    <div class="relative h-[250px] md:h-[380px] overflow-hidden rounded-3xl shadow-2xl transition-all duration-300 group-hover:shadow-brandBlue/20 group-hover:-translate-y-2">
                        <img src="{{ $cat->image_path ?? ($catImages[$index] ?? asset('images/knitwear.png')) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                        <div class="absolute inset-0 bg-black/30 group-hover:bg-black/20 transition-colors"></div>
                        <div class="absolute inset-0 flex items-end justify-center pb-8">
                            <span class="text-white text-xl md:text-2xl font-serif italic font-bold tracking-wider drop-shadow-lg border-b-2 border-white/70 pb-1">{{ $cat->name }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Product Slider Section -->
    <section class="py-16 bg-[#FDFBF7]" 
             x-data="{ 
                activeTab: 'best_sellers',
                isPaused: false,
                scroll() {
                    if (!this.isPaused) {
                        const slider = document.getElementById('slider-' + this.activeTab);
                        if (slider) {
                            slider.scrollLeft += 0.6; // Kecepatan scroll halus
                            if (slider.scrollLeft >= slider.scrollWidth - slider.offsetWidth - 1) {
                                slider.scrollLeft = 0;
                            }
                        }
                    }
                    requestAnimationFrame(() => this.scroll());
                },
                init() {
                    this.scroll();
                }
             }">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-10">
                <h2 class="text-3xl md:text-4xl font-sans font-medium text-textMain text-center md:text-left">Shop Categories</h2>
                <div class="flex flex-wrap justify-center gap-4 md:gap-8 mt-6 md:mt-0">
                    <button @click="activeTab = 'best_sellers'" 
                            class="font-sans text-lg border-b pb-1 transition-all"
                            :class="activeTab === 'best_sellers' ? 'text-textMain border-current' : 'text-gray-500 border-transparent hover:text-textMain hover:border-current'">
                        Best Sellers
                    </button>
                    <button @click="activeTab = 'new_arrivals'" 
                            class="font-sans text-lg border-b pb-1 transition-all"
                            :class="activeTab === 'new_arrivals' ? 'text-textMain border-current' : 'text-gray-500 border-transparent hover:text-textMain hover:border-current'">
                        New Arrivals
                    </button>
                    <button @click="activeTab = 'sale'" 
                            class="font-sans text-lg border-b pb-1 transition-all"
                            :class="activeTab === 'sale' ? 'text-textMain border-current' : 'text-gray-500 border-transparent hover:text-textMain hover:border-current'">
                        Sale
                    </button>
                </div>
            </div>
            
            <div class="relative group" @mouseenter="isPaused = true" @mouseleave="isPaused = false">
                <!-- Best Sellers -->
                <div x-show="activeTab === 'best_sellers'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="flex gap-6 overflow-x-auto hide-scrollbar pb-8" id="slider-best_sellers">
                    @forelse($bestSellers as $product)
                        @include('web.partials.product-card', ['product' => $product])
                    @empty
                        <div class="w-full text-center py-10 text-gray-400 font-sans italic">No best sellers available yet.</div>
                    @endforelse
                </div>

                <!-- New Arrivals -->
                <div x-show="activeTab === 'new_arrivals'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="flex gap-6 overflow-x-auto hide-scrollbar pb-8" id="slider-new_arrivals">
                    @forelse($newArrivals as $product)
                        @include('web.partials.product-card', ['product' => $product])
                    @empty
                        <div class="w-full text-center py-10 text-gray-400 font-sans italic">No new arrivals available yet.</div>
                    @endforelse
                </div>

                <!-- Sale -->
                <div x-show="activeTab === 'sale'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="flex gap-6 overflow-x-auto hide-scrollbar pb-8" id="slider-sale">
                    @forelse($saleProducts as $product)
                        @include('web.partials.product-card', ['product' => $product])
                    @empty
                        <div class="w-full text-center py-10 text-gray-400 font-sans italic">No products on sale available yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- Shop CTA -->
            <div class="mt-12 text-center">
                <a href="{{ route('shop') }}" class="inline-block border border-textMain px-10 py-4 text-sm tracking-widest uppercase hover:bg-textMain hover:text-white transition-all duration-300 font-sans font-medium rounded shadow-sm">
                    Show All Products
                </a>
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
