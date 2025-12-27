@extends('layouts.admin')

@section('title', 'Inventory Management - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Inventory</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Track stock levels across all warehouses</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 dark:bg-gray-800 text-slate-500 dark:text-slate-400 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Product / Variant</th>
                        <th class="px-6 py-4">Warehouse</th>
                        <th class="px-6 py-4">Current Stock</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Last Updated</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                    @forelse($stocks as $stock)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 dark:text-white">
                                {{ $stock->product->product_name }}
                            </div>
                            @if($stock->variant)
                                <div class="text-xs text-blue-600 font-medium">
                                    Variant: {{ $stock->variant->attributes['name'] ?? 'N/A' }}
                                </div>
                            @endif
                            <div class="text-xs text-slate-500 mt-0.5">
                                SKU: {{ $stock->variant ? $stock->variant->sku : $stock->product->sku }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            {{ $stock->warehouse->name }}
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                            {{ $stock->current_stock }}
                        </td>
                         <td class="px-6 py-4">
                            @if($stock->current_stock <= 0)
                                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-semibold">Out of Stock</span>
                            @elseif($stock->current_stock <= ($stock->minimum_stock ?? 5))
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-semibold">Low Stock</span>
                            @else
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">In Stock</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400 text-xs">
                            {{ $stock->updated_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            No inventory records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-200 dark:border-gray-800">
            {{ $stocks->links() }}
        </div>
    </div>
</div>
@endsection
