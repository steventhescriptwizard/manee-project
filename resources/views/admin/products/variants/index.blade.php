@extends('layouts.admin')

@section('title', 'Manage Variants - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-slate-500 hover:text-slate-900 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-lg transition-colors">
            <span class="material-symbols-outlined block">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Variants: {{ $product->product_name }}</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage size, color, and other variations</p>
        </div>
        <div class="ml-auto">
            <a href="{{ route('admin.products.variants.create', $product) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Add Variant
            </a>
        </div>
    </div>


    <div class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 dark:bg-gray-800 text-slate-500 dark:text-slate-400 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Variant Name</th>
                        <th class="px-6 py-4">Color</th>
                        <th class="px-6 py-4">Size</th>
                        <th class="px-6 py-4">SKU</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Inventory</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                    @forelse($variants as $variant)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                            {{ $variant->attributes['name'] ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                            @if($variant->color)
                                <div class="flex items-center gap-2">
                                    <div class="h-4 w-4 rounded-full border border-slate-200 shadow-sm" style="background-color: {{ strtolower($variant->color) }};"></div>
                                    <span>{{ $variant->color }}</span>
                                </div>
                            @else
                                <span class="text-slate-400 italic">None</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">
                            {{ $variant->size ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                            {{ $variant->sku }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">
                            Rp {{ number_format($variant->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($variant->track_inventory)
                                @php
                                    $totalStock = $variant->stocks()->sum('current_stock');
                                @endphp
                                <span class="{{ $totalStock <= 5 ? 'text-red-600' : 'text-slate-600' }}">
                                    {{ $totalStock }} in stock
                                </span>
                            @else
                                <span class="text-slate-400 italic">Unlimited</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.variants.edit', [$product, $variant]) }}" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <form action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}" method="POST" class="inline-block">
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
                            No variants found. This product is sold as a single item.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-200 dark:border-gray-800">
            {{ $variants->links() }}
        </div>
    </div>
</div>
@endsection
