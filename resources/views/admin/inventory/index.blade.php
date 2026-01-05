@extends('layouts.admin')

@section('title', 'Inventory Management - Maneé Admin')

@section('content')
<div class="max-w-[1400px] mx-auto flex flex-col gap-6" x-data="{ adjustStock: null }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Inventory</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Track stock levels across all warehouses</p>
        </div>
        <a href="{{ route('admin.inventory.logs') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <span class="material-symbols-outlined text-[20px]">history</span>
            View Logs
        </a>
    </div>

    <!-- Search Bar -->
    <form method="GET" class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm p-4">
        <div class="flex gap-3">
            <div class="flex-1 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Search by product name, SKU, variant..." 
                    class="w-full pl-10 pr-4 py-2 rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.inventory.index') }}" class="px-6 py-2 border border-slate-300 dark:border-gray-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                    Clear
                </a>
            @endif
        </div>
    </form>

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
                        <th class="px-6 py-4 text-right">Actions</th>
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
                        <td class="px-6 py-4 text-right">
                            <button 
                                @click="adjustStock = {{ $stock->id }}"
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-xs font-medium">
                                <span class="material-symbols-outlined text-[16px]">tune</span>
                                Adjust
                            </button>
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

    <!-- Stock Adjustment Modal -->
    @foreach($stocks as $stock)
    <div x-show="adjustStock === {{ $stock->id }}" 
         x-cloak
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
         @click.self="adjustStock = null">
        <div class="bg-white dark:bg-gray-900 rounded-xl p-6 max-w-md w-full mx-4 border border-slate-200 dark:border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Adjust Stock</h3>
                <button @click="adjustStock = null" class="text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <div class="mb-4 p-3 bg-slate-50 dark:bg-gray-800 rounded-lg">
                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $stock->product->product_name }}</p>
                @if($stock->variant)
                    <p class="text-xs text-blue-600">{{ $stock->variant->color ?? '' }} {{ $stock->variant->size ?? '' }}</p>
                @endif
                <p class="text-xs text-slate-500 mt-1">Current Stock: <span class="font-bold">{{ $stock->current_stock }}</span></p>
            </div>

            <form action="{{ route('admin.inventory.update', $stock) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Adjustment Type</label>
                    <select name="adjustment_type" required class="w-full mt-1 rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                        <option value="in">Stock In (+)</option>
                        <option value="out">Stock Out (-)</option>
                    </select>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Quantity</label>
                    <input type="number" name="quantity" min="1" required class="w-full mt-1 rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                </div>
                
                <div>
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Notes (Optional)</label>
                    <textarea name="notes" rows="2" class="w-full mt-1 rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm"></textarea>
                </div>
                
                <div class="flex gap-2 pt-2">
                    <button type="button" @click="adjustStock = null" class="flex-1 px-4 py-2 border border-slate-300 dark:border-gray-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Adjust Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
