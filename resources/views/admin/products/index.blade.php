@extends('layouts.admin')

@php
    $breadcrumbs = [
        ['label' => 'Daftar Produk', 'url' => null]
    ];
@endphp

@section('title', 'Products - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Products</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage your product catalog</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Add Product
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-slate-200 dark:border-gray-700 shadow-sm p-4">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center">
            {{-- Search --}}
            <div class="relative w-full lg:w-96">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    search
                </span>
                <input
                    name="search"
                    value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 h-10 bg-slate-50 dark:bg-gray-900/50 border border-slate-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 text-slate-900 dark:text-white placeholder:text-slate-400 transition-all outline-none"
                    placeholder="Search by Product Name or SKU"
                    type="text"
                />
            </div>

            {{-- Filters --}}
            <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                <div class="relative group">
                    <select name="category" onchange="this.form.submit()" class="appearance-none h-10 pl-3 pr-8 bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/20 cursor-pointer hover:border-slate-300 dark:hover:border-gray-600 transition-colors">
                        <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>Category: All</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[20px]">
                        expand_more
                    </span>
                </div>
                <div class="relative group">
                    <select name="stock_status" onchange="this.form.submit()" class="appearance-none h-10 pl-3 pr-8 bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600/20 cursor-pointer hover:border-slate-300 dark:hover:border-gray-600 transition-colors">
                        <option value="" {{ !request('stock_status') ? 'selected' : '' }}>Stock: All</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock (≤10)</option>
                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[20px]">
                        expand_more
                    </span>
                </div>
                <button type="submit" class="h-10 px-4 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Search
                </button>
                @if(request()->hasAny(['search', 'category', 'stock_status']))
                    <a href="{{ route('admin.products.index') }}" class="h-10 px-4 bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-slate-400 rounded-lg text-sm font-medium hover:bg-slate-200 dark:hover:bg-gray-600 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>


    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 dark:bg-gray-800 text-slate-500 dark:text-slate-400 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Inventory</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-slate-100 dark:bg-gray-700 h-10 w-10 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($product->image_main)
                                        <img src="{{ Storage::url($product->image_main) }}" alt="{{ $product->product_name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-slate-400">image</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 dark:text-white">{{ $product->product_name }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">SKU: {{ $product->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($product->categories as $category)
                                    <span class="bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-slate-300 px-2 py-0.5 rounded text-xs">
                                        {{ $category->name }}
                                    </span>
                                @empty
                                    <span class="text-slate-400 text-xs italic">Uncategorized</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($product->track_inventory)
                                @php
                                    $totalStock = $product->stocks()->sum('current_stock');
                                @endphp
                                <span class="{{ $totalStock <= 10 ? 'text-red-600' : 'text-slate-600 dark:text-slate-400' }}">
                                    {{ $totalStock }} in stock
                                </span>
                            @else
                                <span class="text-slate-400 italic">Unlimited</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.show', $product) }}" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View Details">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Product">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            No products found. Start by adding one!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-slate-200 dark:border-gray-800">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
