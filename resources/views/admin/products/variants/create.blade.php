@extends('layouts.admin')

@section('title', 'Add Variant - Maneé Admin')

@section('content')
<div class="max-w-2xl mx-auto flex flex-col gap-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.products.variants.index', $product) }}" class="p-2 text-slate-500 hover:text-slate-900 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-lg transition-colors">
            <span class="material-symbols-outlined block">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Add Variant</h1>
    </div>

    <form action="{{ route('admin.products.variants.store', $product) }}" method="POST" class="flex flex-col gap-6">
        @csrf
        
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Color</label>
                    <input type="text" name="color" value="{{ old('color') }}" placeholder="e.g. Red, #FF0000" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                    @error('color') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Size</label>
                    <input type="text" name="size" id="size_input" value="{{ old('size') }}" placeholder="e.g. S, M, L, XL" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach(['S', 'M', 'L', 'XL', 'All Size'] as $quickSize)
                        <button type="button" onclick="document.getElementById('size_input').value = '{{ $quickSize }}'" class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-gray-800 text-slate-600 dark:text-slate-400 rounded hover:bg-blue-600 hover:text-white transition-colors">
                            {{ $quickSize }}
                        </button>
                        @endforeach
                    </div>
                    @error('size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Variant Name (Optional)</label>
                <input type="text" name="variant_name" value="{{ old('variant_name') }}" placeholder="Leave blank to auto-generate from Color/Size" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                @error('variant_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">SKU (Optional)</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" placeholder="Auto-generated if blank" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                    @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div x-data="{ price: {{ old('price', $product->price) }}, exchangeRate: 15500 }">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Price Override (IDR)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-bold text-[10px]">Rp</span>
                        <input type="number" name="price" x-model="price" class="w-full pl-8 rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600" required>
                    </div>
                    <div class="mt-1.5 p-1.5 bg-slate-50 dark:bg-gray-800/50 rounded-lg border border-slate-100 dark:border-gray-800 flex items-center justify-between">
                        <span class="text-[8px] uppercase font-bold text-slate-400">USD Equiv.</span>
                        <span class="text-xs font-mono font-bold text-blue-600">$<span x-text="(price / exchangeRate).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span></span>
                    </div>
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 dark:border-gray-800">
                <div class="flex items-center gap-2 mb-4">
                    <input type="checkbox" id="track_inventory" name="track_inventory" value="1" {{ old('track_inventory', true) ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                    <label for="track_inventory" class="text-sm font-medium text-slate-700 dark:text-slate-300">Track Inventory</label>
                </div>
                
                <div id="stock_field">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Initial Stock</label>
                    <input type="number" name="initial_stock" value="{{ old('initial_stock', 0) }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                </div>
            </div>
            
             <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Weight</label>
                    <input type="number" step="0.01" name="weight" value="{{ old('weight') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-blue-600/20">
            Save Variant
        </button>
    </form>
</div>
@endsection
