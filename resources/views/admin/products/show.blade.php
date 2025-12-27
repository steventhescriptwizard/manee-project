@extends('layouts.admin')

@section('title', 'Product Details - Maneé Admin')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col gap-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products.index') }}" class="p-2 text-slate-500 hover:text-slate-900 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-lg transition-colors">
                <span class="material-symbols-outlined block">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $product->product_name }}</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm italic">SKU: {{ $product->sku }}</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-blue-600/20">
                <span class="material-symbols-outlined text-[20px]">edit</span>
                Edit Product
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Details Card -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider text-sm">General Information</h3>
                    <div class="flex gap-2">
                        @if($product->is_new_arrival)
                            <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-widest">New</span>
                        @endif
                        @if($product->is_best_seller)
                            <span class="bg-amber-50 text-amber-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-widest">Best Seller</span>
                        @endif
                        @if($product->on_sale)
                            <span class="bg-red-50 text-red-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-widest">Sale</span>
                        @endif
                    </div>
                </div>
                <div class="p-8 space-y-6">
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Description</h4>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ $product->description ?: 'No description provided.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pt-6 border-t border-slate-50 dark:border-gray-800">
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Price (IDR)</h4>
                            <p class="text-lg font-bold text-slate-900 dark:text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Price (USD)</h4>
                            <p class="text-lg font-bold text-blue-600 font-mono">${{ number_format($product->price / 15500, 2) }}</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Weight</h4>
                            <p class="text-lg font-medium text-slate-900 dark:text-white">{{ $product->weight ?: '-' }} kg</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Unit</h4>
                            <p class="text-lg font-medium text-slate-900 dark:text-white">{{ $product->unit_of_measure ?: 'pcs' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-slate-200 dark:border-gray-800 shadow-sm p-6">
                <h3 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider text-sm mb-4">Categories</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($product->categories as $category)
                        <span class="bg-slate-100 dark:bg-gray-800 text-slate-600 dark:text-slate-400 px-3 py-1.5 rounded-lg text-sm font-medium border border-slate-200 dark:border-gray-700">
                            {{ $category->name }}
                        </span>
                    @empty
                        <span class="text-slate-400 italic text-sm">No categories assigned.</span>
                    @endforelse
                </div>
            </div>

            <!-- Inventory -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-gray-800 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider text-sm">Inventory Status</h3>
                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $product->track_inventory ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                        {{ $product->track_inventory ? 'Tracking Enabled' : 'Not Tracked' }}
                    </span>
                </div>
                <div class="p-6">
                    @if($product->track_inventory)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($product->stocks as $stock)
                                <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-gray-800/50 rounded-xl border border-slate-100 dark:border-gray-800">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-slate-400">warehouse</span>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $stock->warehouse->name }}</p>
                                            <p class="text-xs text-slate-500">Location: {{ $stock->warehouse->location }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold {{ $stock->current_stock <= 10 ? 'text-red-600' : 'text-blue-600' }}">
                                            {{ $stock->current_stock }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 uppercase font-bold">In Stock</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <span class="material-symbols-outlined text-slate-300 text-4xl mb-2">all_inclusive</span>
                            <p class="text-slate-500 italic">This product has unlimited inventory.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar (Images) -->
        <div class="space-y-8">
            <!-- Primary Image -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-slate-200 dark:border-gray-800 shadow-sm p-4 text-center">
                <h3 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider text-[10px] mb-4 text-left p-2">Primary Image</h3>
                <div class="aspect-[3/4] rounded-xl overflow-hidden bg-slate-50 dark:bg-gray-800 border border-slate-100 dark:border-gray-700">
                    @if($product->image_main)
                        <img src="{{ Storage::url($product->image_main) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                            <span class="material-symbols-outlined text-5xl mb-2">image</span>
                            <span class="text-xs font-bold uppercase">No Image</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Gallery -->
            @if($product->images->count() > 0)
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-slate-200 dark:border-gray-800 shadow-sm p-4">
                <h3 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider text-[10px] mb-4 p-2">Gallery</h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($product->images as $img)
                        <div class="aspect-square rounded-lg overflow-hidden border border-slate-100 dark:border-gray-800">
                            <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Variants Quick Count -->
            <div class="bg-slate-900 dark:bg-blue-600 rounded-2xl p-6 text-white shadow-xl shadow-blue-600/10">
                <div class="flex items-center justify-between mb-4">
                    <span class="material-symbols-outlined text-3xl opacity-50">style</span>
                    <a href="{{ route('admin.products.variants.index', $product) }}" class="text-[10px] font-bold uppercase bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-full transition-colors">Manage</a>
                </div>
                <h4 class="text-3xl font-bold mb-1">{{ $product->variants->count() }}</h4>
                <p class="text-xs font-medium text-white/70 uppercase tracking-widest">Active Variants</p>
            </div>
        </div>
    </div>
</div>
@endsection
