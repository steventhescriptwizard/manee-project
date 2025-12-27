@extends('layouts.admin')

@section('title', 'Edit Product - Maneé Admin')

@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.products.index') }}" class="p-2 text-slate-500 hover:text-slate-900 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-lg transition-colors">
            <span class="material-symbols-outlined block">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Edit Product</h1>
        <div class="ml-auto">
            <a href="{{ route('admin.products.variants.index', $product) }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-[20px]">style</span>
                Manage Variants
            </a>
        </div>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @method('PUT')
        
        <!-- Left Column -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <!-- General Info -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">General Information</h3>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Product Name</label>
                    <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600" required>
                    @error('product_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Description</label>
                    <textarea name="description" rows="4" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">{{ old('description', $product->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Pricing & Inventory -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Pricing & Inventory</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Price</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">$</span>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full pl-7 rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                        </div>
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                        @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Barcode (Optional)</label>
                        <input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}" class="w-full rounded-lg border-slate-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-slate-900 dark:text-white focus:ring-blue-600 focus:border-blue-600">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200 dark:border-gray-800">
                    <div class="flex items-center gap-2 mb-4">
                        <input type="checkbox" id="track_inventory" name="track_inventory" value="1" {{ old('track_inventory', $product->track_inventory) ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                        <label for="track_inventory" class="text-sm font-medium text-slate-700 dark:text-slate-300">Track Inventory</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="flex flex-col gap-6">
            <!-- Media -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Media</h3>
                
                <div class="border-2 border-dashed border-slate-300 dark:border-gray-700 rounded-lg p-6 text-center hover:bg-slate-50 dark:hover:bg-gray-800 transition-colors">
                    <div class="flex flex-col items-center">
                        <span class="material-symbols-outlined text-slate-400 text-3xl mb-2">cloud_upload</span>
                        <label for="image_main" class="cursor-pointer text-sm font-semibold text-blue-600 hover:text-blue-500">
                            Change Image
                            <input type="file" id="image_main" name="image_main" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </label>
                        <p class="text-xs text-slate-500 mt-1">PNG, JPG up to 2MB</p>
                    </div>
                    <img id="preview" src="{{ $product->image_main ? Storage::url($product->image_main) : '' }}" class="mt-4 max-h-40 rounded-lg mx-auto {{ $product->image_main ? '' : 'hidden' }} object-cover">
                </div>
                @error('image_main') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Organization -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl border border-slate-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Organization</h3>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Categories</label>
                    <div class="max-h-60 overflow-y-auto space-y-2 border border-slate-200 dark:border-gray-800 rounded-lg p-3">
                        @foreach($categories as $category)
                            <div>
                                <label class="inline-flex items-center gap-2">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ $product->categories->contains($category->id) ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                                    <span class="text-sm font-semibold">{{ $category->name }}</span>
                                </label>
                                @if($category->children->count() > 0)
                                    <div class="ml-6 mt-1 space-y-1">
                                        @foreach($category->children as $child)
                                            <label class="block items-center gap-2">
                                                <input type="checkbox" name="categories[]" value="{{ $child->id }}" {{ $product->categories->contains($child->id) ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
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
                Update Product
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
