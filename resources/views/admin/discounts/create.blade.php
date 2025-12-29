@extends('layouts.admin')

@section('title', 'Add Discount - Maneé Admin')

@section('content')
<div class="max-w-2xl mx-auto flex flex-col gap-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.discounts.index') }}" class="p-2 text-slate-500 hover:text-slate-900 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-lg transition-colors">
            <span class="material-symbols-outlined block">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Add New Discount</h1>
    </div>

    <form action="{{ route('admin.discounts.store') }}" method="POST" class="flex flex-col gap-6">
        @csrf
        
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
            
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Discount Name</label>
                <input type="text" name="discount_name" value="{{ old('discount_name') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600" required placeholder="e.g. Summer Sale 2024">
                @error('discount_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Type</label>
                    <select name="discount_type" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                        <option value="PERCENT" {{ old('discount_type') == 'PERCENT' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="FIXED" {{ old('discount_type') == 'FIXED' ? 'selected' : '' }}>Fixed Amount ($)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Value</label>
                    <input type="number" step="0.01" name="discount_value" value="{{ old('discount_value') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600" required>
                    @error('discount_value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600" required>
                    @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600" required>
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Min Purchase (Optional)</label>
                    <input type="number" step="0.01" name="min_purchase" value="{{ old('min_purchase') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Max Discount (Optional)</label>
                    <input type="number" step="0.01" name="max_discount" value="{{ old('max_discount') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600" placeholder="For percentage deals">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <!-- Categories Selection -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Applicable Categories (Optional)</label>
                    <div class="border border-slate-300 dark:border-gray-700 rounded-lg p-4 max-h-60 overflow-y-auto bg-white dark:bg-gray-800 space-y-2">
                        @foreach($categories as $category)
                            <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 dark:hover:bg-gray-700 rounded-lg cursor-pointer transition-colors">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                    {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                    class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                                <span class="text-slate-700 dark:text-slate-200">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Select specific categories to apply discount to.</p>
                </div>

                <!-- Products Search & Select -->
                <div x-data="productSelector({{ json_encode($products) }})">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Applicable Products (Optional)</label>
                    
                    <!-- Search Input -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="material-symbols-outlined text-slate-400">search</span>
                        </span>
                        <input type="text" 
                               x-model="search" 
                               placeholder="Search products..." 
                               class="w-full pl-10 pr-4 py-2 rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                        
                        <!-- Dropdown Results -->
                        <div x-show="search.length > 0 && filteredProducts.length > 0" 
                             @click.away="search = ''"
                             class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            <template x-for="product in filteredProducts" :key="product.id">
                                <div @click="selectProduct(product)" 
                                     class="px-4 py-2 hover:bg-slate-50 dark:hover:bg-gray-700 cursor-pointer flex items-center justify-between group">
                                    <span x-text="product.product_name" class="text-slate-700 dark:text-slate-200"></span>
                                    <span class="material-symbols-outlined text-blue-600 opacity-0 group-hover:opacity-100 text-sm">add_circle</span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Selected Products List -->
                    <div class="mt-3 flex flex-wrap gap-2">
                        <template x-for="product in selectedProducts" :key="product.id">
                            <div class="inline-flex items-center gap-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm border border-blue-100 dark:border-blue-800">
                                <span x-text="product.product_name"></span>
                                <button type="button" @click="removeProduct(product.id)" class="hover:text-blue-900 dark:hover:text-blue-100 flex items-center">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                                <input type="hidden" name="products[]" :value="product.id">
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <script>
                function productSelector(allProducts) {
                    return {
                        search: '',
                        products: allProducts,
                        selectedProducts: [], 
                        
                        get filteredProducts() {
                            if (this.search === '') return [];
                            return this.products.filter(product => {
                                // Filter by name and exclude already selected
                                return product.product_name.toLowerCase().includes(this.search.toLowerCase()) && 
                                       !this.selectedProducts.find(p => p.id === product.id);
                            });
                        },

                        selectProduct(product) {
                            this.selectedProducts.push(product);
                            this.search = '';
                        },

                        removeProduct(id) {
                            this.selectedProducts = this.selectedProducts.filter(p => p.id !== id);
                        }
                    }
                }
            </script>

            <div class="pt-4 border-t border-slate-200 dark:border-gray-800">
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                    <label for="is_active" class="text-sm font-medium text-slate-700 dark:text-slate-300">Active</label>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-blue-600/20">
            Save Discount
        </button>
    </form>
</div>
@endsection
