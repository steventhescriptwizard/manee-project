@extends('layouts.web')

@section('title', $category->name . ' - Maneé Fashion Store')

@section('content')
<div class="min-h-screen flex flex-col font-sans antialiased bg-white pt-24">
    
    <!-- Breadcrumbs -->
    <div class="max-w-[1280px] mx-auto px-4 md:px-8 py-4 w-full">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-brandBlue transition-colors">Home</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="hover:text-brandBlue transition-colors">Shop</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-textMain font-medium">{{ $category->name }}</span>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="max-w-[1280px] mx-auto px-4 md:px-8 mb-12 w-full">
        <div class="relative w-full h-[350px] md:h-[500px] rounded-xl overflow-hidden group">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 group-hover:scale-105" 
                 style="background-image: url('{{ asset($heroImage) }}');">
            </div>
            <div class="absolute inset-0 bg-black/20 flex flex-col justify-center items-center text-center p-6">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-4 drop-shadow-md uppercase tracking-tight font-serif italic">
                    {{ $category->name }}
                </h1>
                <p class="text-lg md:text-xl text-white/90 max-w-2xl font-sans font-light mb-8 drop-shadow-sm">
                    {{ $category->description ?? 'Effortless styles designed for the modern woman. From work to weekend, discover silhouettes that celebrate you.' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Filter Bar (Simulating Reference) -->
    <div class="max-w-[1280px] mx-auto px-4 md:px-8 mb-12 w-full">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-gray-100 pb-8">
            <div class="flex flex-wrap gap-3">
                <button class="px-5 py-2 rounded-full bg-textMain text-white text-sm font-medium hover:bg-textMain/90 transition-colors">All {{ $category->name }}</button>
                <button class="px-5 py-2 rounded-full bg-gray-100 text-textMain text-sm font-medium hover:bg-brandBlue/20 transition-colors">New Arrivals</button>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="relative group">
                    <button class="flex items-center gap-2 text-sm font-medium text-textMain hover:text-brandBlue transition-colors">
                        <span class="material-symbols-outlined text-[20px]">tune</span>
                        Filter & Sort
                    </button>
                </div>
                <span class="text-gray-500 text-sm ml-auto md:ml-0">Showing {{ $products->count() }} of {{ $products->total() }} results</span>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="max-w-7xl mx-auto px-6 pb-24 w-full">
        @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-12">
                @foreach($products as $product)
                    @include('web.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-20">
                {{ $products->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                <span class="material-symbols-outlined text-6xl text-gray-300 mb-4 font-light">inventory_2</span>
                <h3 class="text-xl font-serif font-bold text-textMain mb-2">No products found</h3>
                <p class="text-gray-500">We're currently updating this collection. Check back soon!</p>
                <a href="{{ route('home') }}" class="mt-6 inline-flex h-12 items-center justify-center rounded-full bg-textMain px-8 text-sm font-bold text-white transition-all hover:opacity-80">
                    Browse All Collections
                </a>
            </div>
        @endif
    </div>

    <!-- About Category / SEO Section -->
    <div class="bg-brandCream py-24 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-serif font-bold text-textMain mb-8 italic">Maneé Quality Assurance</h2>
            <p class="text-gray-600 leading-relaxed text-lg mb-12">
                Every Maneé piece is self-manufactured with attention to detail and fit. We believe that looking good shouldn't break the bank. Our {{ strtolower($category->name) }} collection features breathable fabrics perfect for the tropical climate.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="flex flex-col items-center gap-4">
                    <div class="size-16 rounded-2xl bg-white flex items-center justify-center shadow-lg shadow-brandBlue/5">
                        <span class="material-symbols-outlined text-3xl text-brandBlue">checkroom</span>
                    </div>
                    <span class="font-serif font-bold text-lg text-textMain">Premium Fabric</span>
                </div>
                <div class="flex flex-col items-center gap-4">
                    <div class="size-16 rounded-2xl bg-white flex items-center justify-center shadow-lg shadow-brandBlue/5">
                        <span class="material-symbols-outlined text-3xl text-brandBlue">local_shipping</span>
                    </div>
                    <span class="font-serif font-bold text-lg text-textMain">Fast Shipping</span>
                </div>
                <div class="flex flex-col items-center gap-4">
                    <div class="size-16 rounded-2xl bg-white flex items-center justify-center shadow-lg shadow-brandBlue/5">
                        <span class="material-symbols-outlined text-3xl text-brandBlue">verified</span>
                    </div>
                    <span class="font-serif font-bold text-lg text-textMain">Quality Checked</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
