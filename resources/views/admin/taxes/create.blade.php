@extends('layouts.admin')

@section('title', 'Add New Tax')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.taxes.index') }}" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-gray-800 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Add New Tax</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Configure a new tax rate.</p>
        </div>
    </div>

    <form action="{{ route('admin.taxes.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-slate-200 dark:border-gray-700 p-6 space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                Tax Name <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="{{ old('name') }}"
                class="w-full rounded-lg border-slate-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                placeholder="e.g. VAT 11%"
                required // turbo
            >
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Rate -->
            <div>
                <label for="rate" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                    Rate (%) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="number" 
                        name="rate" 
                        id="rate" 
                        value="{{ old('rate') }}"
                        step="0.01"
                        min="0"
                        class="w-full rounded-lg border-slate-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500 sm:text-sm pr-8"
                        placeholder="11.00"
                        required
                    >
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-slate-500 sm:text-sm">%</span>
                    </div>
                </div>
                @error('rate')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                    Tax Type <span class="text-red-500">*</span>
                </label>
                <select 
                    name="type" 
                    id="type"
                    class="w-full rounded-lg border-slate-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
                    <option value="sales" {{ old('type') == 'sales' ? 'selected' : '' }}>Sales Tax</option>
                    <option value="purchase" {{ old('type') == 'purchase' ? 'selected' : '' }}>Purchase Tax</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Status -->
        <div class="flex items-center gap-3 pt-2">
            <input 
                type="checkbox" 
                name="is_active" 
                id="is_active" 
                value="1"
                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                {{ old('is_active', true) ? 'checked' : '' }}
            >
            <label for="is_active" class="text-sm font-medium text-slate-700 dark:text-slate-300">
                Active
            </label>
        </div>

        <div class="pt-6 border-t border-slate-100 dark:border-gray-700 flex justify-end gap-3">
            <a href="{{ route('admin.taxes.index') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 dark:bg-gray-800 dark:text-slate-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Create Tax
            </button>
        </div>
    </form>
</div>
@endsection
