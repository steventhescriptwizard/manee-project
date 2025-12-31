@extends('layouts.admin')

@php
    $breadcrumbs = [
        ['label' => 'Daftar Produk', 'url' => route('admin.products.index')],
        ['label' => 'Add Product', 'url' => null]
    ];
@endphp

@section('title', 'Add Product - Maneé Admin')

@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.products.index') }}" class="p-2 text-slate-500 hover:text-slate-900 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-lg transition-colors">
            <span class="material-symbols-outlined block">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Add New Product</h1>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="confirm-save grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        
        <!-- Left Column -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <!-- General Info -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">General Information</h3>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Product Name</label>
                    <input type="text" name="product_name" value="{{ old('product_name') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600" required placeholder="e.g. Silk Summer Dress">
                    @error('product_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Description</label>
                    <textarea name="description" rows="4" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Details & Care</label>
                    <textarea name="details_and_care" rows="4" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600" placeholder="e.g., 100% Cotton, Machine wash cold...">{{ old('details_and_care') }}</textarea>
                    @error('details_and_care') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Pricing & Inventory -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4"
                 x-data="productPricing()">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Pricing & Inventory</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Price (IDR)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-bold text-xs">Rp</span>
                            <input type="number" name="price" x-model.number="price" class="w-full pl-8 rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600" placeholder="e.g. 150000">
                        </div>
                        <div class="mt-2 p-2 bg-slate-50 dark:bg-gray-800/50 rounded-lg border border-slate-100 dark:border-gray-800 flex items-center justify-between">
                            <span class="text-[10px] uppercase font-bold text-slate-400">USD Equivalent</span>
                            <span class="text-sm font-mono font-bold text-blue-600">$<span x-text="(price / exchangeRate).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span></span>
                        </div>
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Applicable Taxes</label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($taxes as $tax)
                            <label class="inline-flex items-center gap-2 cursor-pointer border border-slate-200 dark:border-gray-800 rounded-lg p-3 hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors"
                                   :class="selectedTaxes.includes('{{ $tax->id }}') ? 'bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800' : ''">
                                <input type="checkbox" name="taxes[]" value="{{ $tax->id }}" x-model="selectedTaxes" class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $tax->name }} ({{ $tax->rate }}%)</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price After Tax Display -->
                <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-900/30 rounded-lg" x-show="selectedTaxes.length > 0" x-transition>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-green-800 dark:text-green-300">Price after Tax (Estimated)</span>
                        <span class="text-lg font-bold text-green-700 dark:text-green-400">
                            Rp <span x-text="priceAfterTax.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 2})"></span>
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                        @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Barcode (Optional)</label>
                        <input type="text" name="barcode" value="{{ old('barcode') }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
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
            </div>
        </div>

        <!-- Right Column -->
        <div class="flex flex-col gap-6">
            <!-- Media -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Primary Image</h3>
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded uppercase">Featured</span>
                </div>
                
                <div class="border-2 border-dashed border-slate-300 dark:border-gray-700 rounded-lg p-6 text-center hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                    <div class="flex flex-col items-center">
                        <span class="material-symbols-outlined text-slate-400 text-3xl mb-2">image</span>
                        <label for="image_main" class="cursor-pointer text-sm font-semibold text-blue-600 hover:text-blue-500">
                            Upload Primary Image
                            <input type="file" id="image_main" name="image_main" class="hidden" accept="image/*" onchange="previewImage(this, 'preview')">
                        </label>
                    </div>
                    <img id="preview" class="mt-4 max-h-48 rounded-lg mx-auto hidden object-cover shadow-sm">
                </div>
                @error('image_main') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Gallery -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4"
                 x-data="{ 
                    queuedFiles: [],
                    dataTransfer: new DataTransfer(),
                    addFiles(input) {
                        Array.from(input.files).forEach(file => {
                            if (!this.queuedFiles.some(f => f.name === file.name && f.size === file.size)) {
                                this.queuedFiles.push({
                                    id: Date.now() + Math.random(),
                                    file: file,
                                    preview: URL.createObjectURL(file)
                                });
                                this.dataTransfer.items.add(file);
                            }
                        });
                        input.files = this.dataTransfer.files;
                    },
                    removeFile(index, inputId) {
                        const fileToRemove = this.queuedFiles[index].file;
                        this.queuedFiles.splice(index, 1);
                        
                        const newDataTransfer = new DataTransfer();
                        Array.from(this.dataTransfer.files).forEach(file => {
                            if (file !== fileToRemove) newDataTransfer.items.add(file);
                        });
                        this.dataTransfer = newDataTransfer;
                        document.getElementById(inputId).files = this.dataTransfer.files;
                    }
                 }">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Product Gallery</h3>
                
                <div class="border-2 border-dashed border-slate-300 dark:border-gray-700 rounded-lg p-6 text-center hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors relative">
                    <div class="flex flex-col items-center">
                        <span class="material-symbols-outlined text-slate-400 text-3xl mb-2">collections</span>
                        <label for="product_gallery" class="cursor-pointer text-sm font-semibold text-blue-600 hover:text-blue-500">
                            Upload Gallery Images
                            <input type="file" id="product_gallery" name="product_gallery[]" class="hidden" accept="image/*" multiple @change="addFiles($el)">
                        </label>
                        <p class="text-xs text-slate-500 mt-1">Select multiple images (Additive)</p>
                    </div>
                </div>
                
                <div id="gallery-preview" class="grid grid-cols-3 gap-3 mt-4">
                    <template x-for="(queued, index) in queuedFiles" :key="queued.id">
                        <div class="relative group aspect-square rounded-lg overflow-hidden border border-blue-200 dark:border-blue-900 ring-2 ring-blue-500/10">
                            <img :src="queued.preview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" @click="removeFile(index, 'product_gallery')" class="p-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-lg">
                                    <span class="material-symbols-outlined text-[18px] block">close</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
                @error('product_gallery.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Organization -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Organization</h3>
                
                <div class="space-y-4 border-b border-slate-100 dark:border-gray-800 pb-4 mb-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Product Labels</label>
                    <div class="grid grid-cols-1 gap-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival') ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-blue-600 transition-colors">New Arrival</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller') ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-blue-600 transition-colors">Best Seller</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="on_sale" value="1" {{ old('on_sale') ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-blue-600 transition-colors">On Sale</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Categories</label>
                    <div class="max-h-60 overflow-y-auto space-y-2 border border-slate-200 dark:border-gray-800 rounded-lg p-3">
                        @foreach($categories as $category)
                            <div>
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                                    <span class="text-sm font-semibold">{{ $category->name }}</span>
                                </label>
                                @if($category->children->count() > 0)
                                    <div class="ml-6 mt-1 space-y-1">
                                        @foreach($category->children as $child)
                                            <label class="block items-center gap-2">
                                                <input type="checkbox" name="categories[]" value="{{ $child->id }}" class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                                                <span class="text-sm text-slate-600 dark:text-slate-400">{{ $child->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-blue-600/20">
                Save Product
            </button>
        </div>
    </form>
</div>

<script>
    function productPricing() {
        return {
            price: {{ old('price', 0) }},
            exchangeRate: 15500,
            selectedTaxes: [],
            taxRates: @json($taxes->pluck('rate', 'id')),
            get priceAfterTax() {
                let totalRate = 0;
                this.selectedTaxes.forEach(taxId => {
                    totalRate += parseFloat(this.taxRates[taxId] || 0);
                });
                return this.price * (1 + totalRate / 100);
            }
        }
    }

    function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById(previewId);
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}


</script>
@endsection
