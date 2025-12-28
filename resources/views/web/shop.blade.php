@extends('layouts.web')

@section('title', 'Shop Collection - Maneé')

@section('content')
<main class="flex-grow w-full max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-20" x-data="{ isMobileFiltersOpen: false }">
    <!-- Page Header -->
    <section class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="flex flex-col gap-2">
            <nav class="flex text-sm text-gray-400 mb-2">
                <a href="{{ route('home') }}" class="hover:text-textMain transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span class="text-textMain font-medium font-sans">Shop</span>
            </nav>
            <h1 class="font-serif text-4xl md:text-5xl font-bold text-textMain tracking-tight">Shop Collection</h1>
            <p class="text-gray-500 mt-1 max-w-md font-light">Timeless pieces for the modern woman. Designed for comfort and elegance.</p>
        </div>
        
        <div class="w-full md:w-96">
            <form action="{{ route('shop') }}" method="GET" class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-gray-400">search</span>
                </div>
                <input 
                    type="text" 
                    name="search"
                    value="{{ request('search') }}"
                    class="block w-full pl-10 pr-3 py-3 border border-gray-100 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brandBlue focus:border-brandBlue sm:text-sm transition-shadow shadow-sm" 
                    placeholder="Search dresses, tops, accessories..." 
                />
            </form>
        </div>
    </section>

    <div class="flex flex-col lg:flex-row gap-8 xl:gap-12">
        <!-- Mobile Filter Toggle -->
        <div class="lg:hidden">
            <button 
                @click="isMobileFiltersOpen = !isMobileFiltersOpen"
                class="w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-100 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors shadow-sm"
            >
                <span class="font-sans font-bold uppercase tracking-widest text-[10px]">Filters & Sort</span>
                <span class="material-symbols-outlined text-lg">tune</span>
            </button>
        </div>

        <!-- Sidebar - Desktop & Mobile -->
        <aside 
            :class="isMobileFiltersOpen ? 'block' : 'hidden lg:block'"
            class="w-full lg:w-64 flex-shrink-0 space-y-8 bg-white lg:bg-transparent p-6 lg:p-0 rounded-xl border border-gray-100 lg:border-none shadow-sm lg:shadow-none"
        >
            <form action="{{ route('shop') }}" method="GET" id="filter-form">
                <!-- Keep search and sort in form -->
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="sort" value="{{ request('sort', 'newest') }}">

                <!-- Categories -->
                <div>
                    <h3 class="font-serif text-xl font-bold mb-4 text-textMain">Categories</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="category" value="" class="w-4 h-4 text-brandBlue border-gray-200 focus:ring-brandBlue" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                            <span class="text-sm {{ !request('category') ? 'text-textMain font-bold' : 'text-gray-400 font-light' }} group-hover:text-textMain transition-colors">All Products</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="category" value="{{ $cat->slug }}" class="w-4 h-4 text-brandBlue border-gray-200 focus:ring-brandBlue" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()">
                            <span class="text-sm {{ request('category') == $cat->slug ? 'text-textMain font-bold' : 'text-gray-400 font-light' }} group-hover:text-textMain transition-colors">{{ $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="w-full h-px bg-gray-100 my-8"></div>

                <!-- Price Range -->
                <div>
                    <h3 class="font-serif text-xl font-bold mb-4 text-textMain">Price Range</h3>
                    <div class="space-y-4">
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 block">Min (Rp)</label>
                                <input 
                                    type="number" 
                                    name="min_price"
                                    value="{{ request('min_price') }}"
                                    placeholder="0" 
                                    class="w-full px-3 py-2 text-sm border border-gray-100 rounded focus:border-brandBlue focus:ring-1 focus:ring-brandBlue focus:outline-none placeholder-gray-300"
                                />
                            </div>
                            <div class="flex-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 block">Max (Rp)</label>
                                <input 
                                    type="number" 
                                    name="max_price"
                                    value="{{ request('max_price') }}"
                                    placeholder="9.000k" 
                                    class="w-full px-3 py-2 text-sm border border-gray-100 rounded focus:border-brandBlue focus:ring-1 focus:ring-brandBlue focus:outline-none placeholder-gray-300"
                                />
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2 bg-textMain text-white rounded text-xs font-bold uppercase tracking-widest hover:bg-black transition-colors">Apply Filter</button>
                    </div>
                </div>

                <div class="w-full h-px bg-gray-100 my-8"></div>

                <!-- Color (Visual only for now, can be linked to variants later) -->
                <div>
                    <h3 class="font-serif text-xl font-bold mb-4 text-textMain">Color</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach(['#FFFFFF', '#000000', '#F5F5DC', '#8B4513', '#708090', '#2F4F4F'] as $hex)
                        <button
                            type="button"
                            class="w-6 h-6 rounded-full ring-2 ring-offset-2 ring-transparent hover:ring-gray-300 transition-all border border-gray-100 shadow-sm"
                            style="background-color: {{ $hex }}"
                        ></button>
                        @endforeach
                    </div>
                </div>

                @if(request()->anyFilled(['category', 'min_price', 'max_price', 'search']))
                <div class="mt-8">
                    <a href="{{ route('shop') }}" class="text-xs text-red-500 font-bold uppercase tracking-widest flex items-center gap-1 hover:underline">
                        <span class="material-symbols-outlined text-sm">close</span>
                        Clear All Filters
                    </a>
                </div>
                @endif
            </form>
        </aside>

        <!-- Product Grid Area -->
        <div class="flex-1">
            <!-- Sort & Count -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pt-2">
                <p class="text-sm text-gray-500 font-light">
                    Showing <span class="font-bold text-textMain">{{ $products->count() }}</span> of <span class="font-bold text-textMain">{{ $products->total() }}</span> products
                </p>
                
                <div class="flex items-center gap-3">
                    <label for="sort-select" class="text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Sort By:</label>
                    <div class="relative group">
                        <select 
                            id="sort-select" 
                            name="sort"
                            form="filter-form"
                            onchange="this.form.submit()"
                            class="appearance-none bg-white border border-gray-100 hover:border-brandBlue py-2.5 pl-4 pr-10 rounded-lg text-sm font-medium text-textMain focus:outline-none focus:ring-1 focus:ring-brandBlue focus:border-brandBlue cursor-pointer transition-all min-w-[200px] shadow-sm"
                        >
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrival</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="alpha_asc" {{ request('sort') == 'alpha_asc' ? 'selected' : '' }}>Alphabetical: A-Z</option>
                            <option value="alpha_desc" {{ request('sort') == 'alpha_desc' ? 'selected' : '' }}>Alphabetical: Z-A</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400 group-hover:text-brandBlue transition-colors">
                            <span class="material-symbols-outlined text-xl">expand_more</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid -->
            @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-12">
                @foreach($products as $product)
                    @include('web.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-24 bg-[#f8f9fc] rounded-3xl border border-dashed border-gray-200">
                <div class="inline-flex items-center justify-center h-20 w-20 bg-white rounded-full shadow-sm mb-6">
                    <span class="material-symbols-outlined text-3xl text-gray-300">inventory_2</span>
                </div>
                <h3 class="text-2xl font-serif font-bold text-textMain mb-2">No products found</h3>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto font-light">We couldn't find any products matching your criteria. Try adjusting your filters or search term.</p>
                <a href="{{ route('shop') }}" class="text-brandBlue font-bold uppercase tracking-widest text-xs hover:underline">Reset All Filters</a>
            </div>
            @endif
        </div>
    </div>
</main>
@endsection
