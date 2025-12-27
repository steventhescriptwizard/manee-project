@extends('layouts.admin')

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

    @if(session('success'))
    <div class="bg-green-50 text-green-600 p-4 rounded-lg text-sm font-medium border border-green-100">
        {{ session('success') }}
    </div>
    @endif

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
                            {{ number_format($product->price, 0, ',', '.') }}
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
                                <a href="{{ route('admin.products.edit', $product) }}" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
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
